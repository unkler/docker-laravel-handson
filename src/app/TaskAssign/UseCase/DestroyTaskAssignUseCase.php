<?php
namespace App\TaskAssign\UseCase;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\TaskAssign;
use App\Models\EmployeeTaskAssign;

final class DestroyTaskAssignUseCase {

    /**
     * 作業を論理削除する
     *
     * @param string $id
     * @return integer
     */
    public function handle(string $id): int
    {
        $response_code = Response::HTTP_OK;

        DB::beginTransaction();

        try {
            $task_assign = TaskAssign::find($id);
            $task_assign->delete();

            EmployeeTaskAssign::where('task_assign_id', $id)->delete();

            DB::commit();
        }catch(\Exception $e) {
            $response_code = Response::HTTP_INTERNAL_SERVER_ERROR;
            \Log::error('TaskAssign deletion failed. ID = ' . $id);
            \Log::error($e->getMessage());

            DB::rollback();
        }

        return $response_code;
    }
}

