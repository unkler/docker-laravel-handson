<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\TaskAssign\UseCase\StoreTaskAssignUseCase;
use App\TaskAssign\Entity\TaskAssignData;

class StoreTaskAssignUseCaseTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
        
        Artisan::call('migrate:fresh --seed');
    }

    /**
     * 作業新規登録のテスト
     *
     * @return void
     */
    public function test_作業を新規登録する(): void
    {
        $task_assign_data = new TaskAssignData(null, 1, [1,2], '2030-01-01');

        $use_case = new StoreTaskAssignUseCase();

        $use_case->handle($task_assign_data);

        $this->assertDatabaseHas('task_assigns', [
            'workplace_id' => $task_assign_data->getWorkplaceId(),
            'implementation_date' => $task_assign_data->getImplementationDate(),
        ]);

        $this->assertDatabaseHas('employee_task_assign', [
            'employee_id' => $task_assign_data->getEmployeeIds()[0],
        ]);

        $this->assertDatabaseHas('employee_task_assign', [
            'employee_id' => $task_assign_data->getEmployeeIds()[1],
        ]);

    }
}
