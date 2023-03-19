<?php
namespace App\Employee\UseCase;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\EmployeeImage;

final class DestroyEmployeeUseCase {

    /**
     * 従業員を論理削除する
     *
     * @param string $id
     * @return integer
     */
    public function handle(string $id): int
    {
        $response_code = Response::HTTP_OK;

        DB::beginTransaction();

        try {
            $employee = Employee::find($id);
            $employee->delete();

            $registered_employee_image = EmployeeImage::where('employee_id', $id)
                    ->where('is_active', true)
                    ->first();

            if (!is_null($registered_employee_image)) {
                $registered_employee_image->is_active = false;
                $registered_employee_image->save();
            }

            DB::commit();
        }catch(\Exception $e) {
            $response_code = Response::HTTP_INTERNAL_SERVER_ERROR;
            \Log::error('Employee deletion failed. ID = ' . $id);
            \Log::error($e->getMessage());
            DB::rollBack();
        }

        return $response_code;
    }
}

