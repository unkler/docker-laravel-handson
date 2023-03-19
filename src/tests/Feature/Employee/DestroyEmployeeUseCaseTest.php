<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Employee;
use App\Employee\UseCase\DestroyEmployeeUseCase;

class DestroyEmployeeUseCaseTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
        
        Artisan::call('migrate:fresh --seed');
    }

    /**
     * 従業員削除のテスト
     *
     * @return void
     */
    public function test_従業員を削除する(): void
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

        $use_case = new DestroyEmployeeUseCase();

        $use_case->handle($employee->id);

        $this->assertSoftDeleted('employees', [
            'id' => $employee->id
        ]);
    }
}
