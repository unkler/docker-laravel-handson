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

final class StoreTaskAssignUseCase {

    /**
     * 作業を新規登録する
     *
     * @param TaskAssignData $task_assign_data
     * @return integer
     */
    public function handle(TaskAssignData $task_assign_data): int
    {
        $response_code = Response::HTTP_CREATED;

        
        DB::beginTransaction();
        
        try {
            $task_assign = TaskAssign::create([
                'workplace_id' => $task_assign_data->getWorkplaceId(),
                'implementation_date' => $task_assign_data->getImplementationDate(),
            ]);
            
            foreach($task_assign_data->getEmployeeIds() as $employee_id) {
                EmployeeTaskAssign::create([
                    'employee_id' => $employee_id,
                    'task_assign_id' => $task_assign->id
                ]);
                
                $workplace = Workplace::find($task_assign_data->getWorkplaceId());
                $employee = Employee::find($employee_id);
                
                SendMailJob::dispatch($workplace, $employee, $task_assign_data->getImplementationDate(), '決定');
            }
            DB::commit();
        }catch(\Exception $e) {
            $response_code = Response::HTTP_INTERNAL_SERVER_ERROR;
            \Log::error('TaskAssign registration failed. ID = none');
            \Log::error($e->getMessage());
            DB::rollBack();
        }

        return $response_code;
    }
}

