<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\TaskAssign;
use App\TaskAssign\UseCase\UpdateTaskAssignUseCase;
use App\TaskAssign\Entity\TaskAssignData;

class UpdateTaskAssignUseCaseTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
        
        Artisan::call('migrate:fresh --seed');
    }

    /**
     * 作業更新のテスト
     *
     * @return void
     */
    public function test_作業を更新する(): void
    {
        $task_assign = TaskAssign::create([
            'workplace_id' => 1,
            'implementation_date' => '2030-01-01'
        ]);

        $task_assign_data = new TaskAssignData($task_assign->id, 1, [2,3], '2030-01-01');

        $use_case = new UpdateTaskAssignUseCase();

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
