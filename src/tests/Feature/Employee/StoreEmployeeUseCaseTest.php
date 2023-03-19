<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Employee\UseCase\StoreEmployeeUseCase;
use App\Employee\Entity\EmployeeData;

class StoreEmployeeUseCaseTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
        
        Artisan::call('migrate:fresh --seed');
    }

    /**
     * 従業員新規登録のテスト
     *
     * @return void
     */
    public function test_従業員を新規登録する(): void
    {
        $employee_data = new EmployeeData(null, 1, '山田', '太郎', 'ヤマダ', 'タロウ', 1000014, 
            13, '千代田区永田町1-7-1', '03-3581-5111', 'test@test.com', '1975-01-01');

        $use_case = new StoreEmployeeUseCase();

        $use_case->handle($employee_data, null);

        $this->assertDatabaseHas('employees', [
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
