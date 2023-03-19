<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Client\UseCase\StoreClientUseCase;
use App\Client\Entity\ClientData;

class StoreClientUseCaseTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
        
        Artisan::call('migrate:fresh --seed');
    }

    /**
     * 取引先新規登録のテスト
     *
     * @return void
     */
    public function test_取引先を新規登録する(): void
    {
        $client_data = new ClientData(null, '株式会社 テスト', 1000014, 
            13, '千代田区永田町1-7-1', '03-3581-5111', 'test@test.com');

        $use_case = new StoreClientUseCase();

        $use_case->handle($client_data);

        $this->assertDatabaseHas('clients', [
            'name' => $client_data->getName(),
            'post_code' => $client_data->getPostCode(),
            'prefecture_id' => $client_data->getPrefectureId(),
            'address' => $client_data->getAddress(),
            'phone_number' => $client_data->getPhoneNumber(),
            'email' => $client_data->getEmail(),
        ]);
    }
}
