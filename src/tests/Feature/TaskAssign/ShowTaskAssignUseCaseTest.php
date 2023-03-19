<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\TaskAssign;
use App\TaskAssign\UseCase\ShowTaskAssignUseCase;

class ShowTaskAssignUseCaseTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
        
        Artisan::call('migrate:fresh --seed');
    }

    /**
     * 作業一覧取得のテスト
     */
    public function test_作業一覧を取得する(): void
    {
        TaskAssign::factory(30)->create();

        $use_case = new ShowTaskAssignUseCase();

        $task_assigns = $use_case->handle(null);

        $this->assertSame(count($task_assigns), \PaginationConstant::NUMBER_PER_PAGE);
    }
}
