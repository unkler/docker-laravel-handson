<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Workplace;
use App\Workplace\UseCase\ShowWorkplaceUseCase;

class ShowWorkplaceUseCaseTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
        
        Artisan::call('migrate:fresh --seed');
    }

    /**
     * 作業場所一覧取得のテスト
     */
    public function test_作業場所一覧を取得する(): void
    {
        Workplace::factory(30)->create();

        $use_case = new ShowWorkplaceUseCase();

        $workplaces = $use_case->handle(null);

        $this->assertSame(count($workplaces), \PaginationConstant::NUMBER_PER_PAGE);

        $this->assertSame([
            'id',
            'client_id',
            'name',
            'post_code',
            'prefecture_id',
            'address',
            'phone_number',
            'clients',
            'prefectures',
            'workplace_images',
        ], array_keys($workplaces[0]->toArray()));
    }
}
