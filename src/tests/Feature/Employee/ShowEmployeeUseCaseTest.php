<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Employee;
use App\Employee\UseCase\ShowEmployeeUseCase;

class ShowEmployeeUseCaseTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
        
        Artisan::call('migrate:fresh --seed');
    }

    /**
     * 従業員一覧取得のテスト
     */
    public function test_従業員一覧を取得する(): void
    {
        Employee::factory(30)->create();

        $use_case = new ShowEmployeeUseCase();

        $employees = $use_case->handle(null);

        $this->assertSame(count($employees), \PaginationConstant::NUMBER_PER_PAGE);

        $this->assertSame([
            'id',
            'contract_type_id',
            'last_name',
            'first_name',
            'last_name_kana',
            'first_name_kana',
            'post_code',
            'prefecture_id',
            'address',
            'phone_number',
            'email',
            'birthday',
            'contract_types',
            'prefectures',
            'employee_images',
        ], array_keys($employees[0]->toArray()));
    }
}
