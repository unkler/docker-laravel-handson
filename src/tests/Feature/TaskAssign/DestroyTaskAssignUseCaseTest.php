<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\TaskAssign;
use App\Models\EmployeeTaskAssign;
use App\TaskAssign\UseCase\DestroyTaskAssignUseCase;

class DestroyTaskAssignUseCaseTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
        
        Artisan::call('migrate:fresh --seed');
    }

    /**
     * 作業削除のテスト
     *
     * @return void
     */
    public function test_作業を削除する(): void
    {
        $task_assign = TaskAssign::create([
            'workplace_id' => 1,
            'implementation_date' => '2030-01-01'
        ]);

        $employee_task_assign = EmployeeTaskAssign::create([
            'employee_id' => 1,
            'task_assign_id' => $task_assign->id,
        ]);

        $use_case = new DestroyTaskAssignUseCase();

        $use_case->handle($task_assign->id);

        $this->assertSoftDeleted('task_assigns', [
            'id' => $task_assign->id,
            'workplace_id' => $task_assign->workplace_id,
            'implementation_date' => $task_assign->implementation_date,
        ]);

        $this->assertSoftDeleted('employee_task_assign', [
            'employee_id' => $employee_task_assign->employee_id,
            'task_assign_id' => $task_assign->id,
        ]);
    }
}
