<?php
namespace App\TaskAssign\UseCase;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\TaskAssign;
use App\Models\Workplace;
use App\Models\Employee;
use App\Models\EmployeeTaskAssign;
use App\TaskAssign\Entity\TaskAssignData;
use App\Jobs\SendMailJob;

final class UpdateTaskAssignUseCase {

    /**
     * 取引先を更新する
     *
     * @param TaskAssignData $task_assign_data
     * @return integer
     */
    public function handle(TaskAssignData $task_assign_data): int
    {
        $response_code = Response::HTTP_CREATED;

        $task_assign = TaskAssign::find($task_assign_data->getId());

        $task_assign->workplace_id = $task_assign_data->getWorkplaceId();
        $task_assign->implementation_date = $task_assign_data->getImplementationDate();

        
        DB::beginTransaction();
        
        try {
            $task_assign->save();
            
            $task_assign->employeeTaskAssigns()->forceDelete();
            
            foreach($task_assign_data->getEmployeeIds() as $employee_id) {
                EmployeeTaskAssign::firstOrCreate([
                    'employee_id' => $employee_id,
                    'task_assign_id' => $task_assign_data->getId(),
                ]);
                
                $workplace = Workplace::find($task_assign_data->getWorkplaceId());
                $employee = Employee::find($employee_id);

                SendMailJob::dispatch($workplace, $employee, $task_assign_data->getImplementationDate(), '変更');
            }
            DB::commit();
        }catch(\Exception $e) {
            $response_code = Response::HTTP_INTERNAL_SERVER_ERROR;
            \Log::error('TaskAssign modification failed. WORKPLACE ID = ' . $workplace->id);
            \Log::error($e->getMessage());
            DB::rollBack();
        }

        return $response_code;
    }
}

