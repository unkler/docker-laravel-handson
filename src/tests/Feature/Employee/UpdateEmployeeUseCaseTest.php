<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Employee;
use App\Employee\UseCase\UpdateEmployeeUseCase;
use App\Employee\Entity\EmployeeData;

class UpdateEmployeeUseCaseTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
        
        Artisan::call('migrate:fresh --seed');
    }

    /**
     * 従業員更新のテスト
     *
     * @return void
     */
    public function test_従業員を更新する(): void
    {
        $employee = Employee::create([
            'contract_type_id' => 1,
            'last_name' => '山田',
            'first_name' => '太郎',
            'last_name_kana' => 'ヤマダ',
            'first_name_kana' => 'タロウ',
            'post_code' => 1000014,
            'prefecture_id' => 13,
            'address' => '千代田区永田町1-7-1',
            'phone_number' => '03-3581-5111',
            'email' => 'test@test.com',
            'birthday' => '1975-01-01'
        ]);

        $employee_data = new EmployeeData($employee->id, 2, '佐藤', '一郎', 'サトウ', 'イチロウ', 5408570, 
            27, '大阪市中央区大手前２丁目 大阪府庁本館１階', '06-6944-8371', 'sample@sample.com', '2000-12-31');

        $use_case = new UpdateEmployeeUseCase();

        $use_case->handle($employee_data, null, false);

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
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
    }
}
