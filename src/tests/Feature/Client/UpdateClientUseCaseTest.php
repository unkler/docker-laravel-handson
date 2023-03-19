<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Client;
use App\Client\UseCase\UpdateClientUseCase;
use App\Client\Entity\ClientData;

class UpdateClientUseCaseTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
        
        Artisan::call('migrate:fresh --seed');
    }

    /**
     * 取引先更新のテスト
     *
     * @return void
     */
    public function test_取引先を更新する(): void
    {
        $client = Client::create([
            'name' => '株式会社 テスト',
            'post_code' => 1000014,
            'prefecture_id' => 13,
            'address' => '千代田区永田町1-7-1',
            'phone_number' => '03-3581-5111',
            'email' => 'test@test.com'
        ]);

        $client_data = new ClientData($client->id, '株式会社 サンプル', 5408570, 
            27, '大阪市中央区大手前２丁目 大阪府庁本館１階', '06-6944-8371', 'sample@sample.com');

        $use_case = new UpdateClientUseCase();

        $use_case->handle($client_data);

        $this->assertDatabaseHas('clients', [
            'id' => $client_data->getId(),
            'name' => $client_data->getName(),
            'post_code' => $client_data->getPostCode(),
            'prefecture_id' => $client_data->getPrefectureId(),
            'address' => $client_data->getAddress(),
            'phone_number' => $client_data->getPhoneNumber(),
            'email' => $client_data->getEmail(),
        ]);
    }
}
