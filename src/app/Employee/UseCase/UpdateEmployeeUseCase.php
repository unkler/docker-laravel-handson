<?php
namespace App\Employee\UseCase;

use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\EmployeeImage;
use App\Employee\Entity\EmployeeData;

final class UpdateEmployeeUseCase {

    /**
     * 従業員を更新する
     *
     * @param EmployeeData $employee_data
     * @param UploadedFile|null $profile_image
     * @param bool $is_delete_registered_image
     * @return integer
     */
    public function handle(EmployeeData $employee_data, ?UploadedFile $profile_image, bool $is_delete_registered_image): int
    {
        $response_code = Response::HTTP_CREATED;

        $employee = Employee::find($employee_data->getId());

        $employee->contract_type_id = $employee_data->getContractTypeId();
        $employee->last_name = $employee_data->getLastName();
        $employee->first_name = $employee_data->getFirstName();
        $employee->last_name_kana = $employee_data->getLastNameKana();
        $employee->first_name_kana = $employee_data->getFirstNameKana();
        $employee->post_code = $employee_data->getPostCode();
        $employee->prefecture_id = $employee_data->getPrefectureId();
        $employee->address = $employee_data->getAddress();
        $employee->phone_number = $employee_data->getPhoneNumber();
        $employee->email = $employee_data->getEmail();
        $employee->birthday = $employee_data->getBirthday();

        DB::beginTransaction();

        try {
            $employee->save();

            // プロフィール画像はis_activeがtrueのレコードが1つのみ存在する仕様のため
            // 削除や更新されている場合、既に登録されているレコードはfalseに変更する
            if($is_delete_registered_image) {
                $registered_employee_image = EmployeeImage::where('employee_id', $employee->id)
                    ->where('is_active', true)
                    ->first();
                
                if (!is_null($registered_employee_image)) {
                    $registered_employee_image->is_active = false;
                    $registered_employee_image->save();
                }
            }

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
            \Log::error('Employee modification failed. ID = ' . $employee->id);
            \Log::error($e->getMessage());
            DB::rollBack();
        }

        return $response_code;
    }
}

