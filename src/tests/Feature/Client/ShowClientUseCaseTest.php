<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Client;
use App\Client\UseCase\ShowClientUseCase;

class ShowClientUseCaseTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
        
        Artisan::call('migrate:fresh --seed');
    }

    /**
     * 取引先一覧取得のテスト
     */
    public function test_取引先一覧を取得する(): void
    {
        Client::factory(30)->create();

        $use_case = new ShowClientUseCase();

        $clients = $use_case->handle(null);

        $this->assertSame(count($clients), \PaginationConstant::NUMBER_PER_PAGE);

        $this->assertSame([
            'id',
            'name',
            'post_code',
            'prefecture_id',
            'address',
            'phone_number',
            'email',
            'prefectures',
        ], array_keys($clients[0]->toArray()));
    }
}
