<?php
namespace App\Employee\UseCase;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use App\Models\Employee;
use App\Models\EmployeeImage;
use App\Employee\Entity\EmployeeData;

final class StoreEmployeeUseCase {

    /**
     * 従業員を新規登録する
     *
     * @param EmployeeData $employee_data
     * @param UploadedFile $profile_image
     * @return integer
     */
    public function handle(EmployeeData $employee_data, ?UploadedFile $profile_image): int
    {

        $response_code = Response::HTTP_CREATED;

        DB::beginTransaction();

        try {
            $employee = Employee::create([
                'contract_type_id' => $employee_data->getContractTypeId(),
                'last_name' => $employee_data->getLastName(),
                'first_name' => $employee_data->getFirstName(),
                'last_name_kana' => $employee_data->getLastNameKana(),
                'first_name_kana' => $employee_data->getFirstNameKana(),
                'post_code' => $employee_data->getPostCode(),
                'prefecture_id' => $employee_data->getPrefectureId(),
                'address' => $employee_data->getAddress(),
                'phone_number' => $employee_data->getPhoneNumber(),
                'email' => $employee_data->getEmail(),
                'birthday' => $employee_data->getBirthday(),
            ]);

            //画像保存処理
            if (isset($profile_image)) {
                $file_path =   $profile_image->store('public/employees');
                EmployeeImage::create([
                    'path' =>   str_replace('public', '/storage', $file_path),
                    'employee_id' => $employee->id,
                    'is_active' => true,
                ]);
            }
            DB::commit();
        }catch(\Throwable $e) {
            $response_code = Response::HTTP_INTERNAL_SERVER_ERROR;
            \Log::error('Employee registration failed. ID = none');
            \Log::error($e->getMessage());
            DB::rollBack();
        }

        return $response_code;
    }
}

