<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Client;
use App\Client\UseCase\DestroyClientUseCase;

class DestroyClientUseCaseTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
        
        Artisan::call('migrate:fresh --seed');
    }

    /**
     * 取引先削除のテスト
     *
     * @return void
     */
    public function test_取引先を削除する(): void
    {
        $client = Client::create([
            'name' => '株式会社 テスト',
            'post_code' => 1000014,
            'prefecture_id' => 13,
            'address' => '千代田区永田町1-7-1',
            'phone_number' => '03-3581-5111',
            'email' => 'test@test.com'
        ]);

        $use_case = new DestroyClientUseCase();

        $use_case->handle($client->id);

        $this->assertSoftDeleted('clients', [
            'id' => $client->id,
        ]);
    }
}
