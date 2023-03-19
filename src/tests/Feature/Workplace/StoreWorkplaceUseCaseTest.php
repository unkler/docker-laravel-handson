<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Workplace\UseCase\StoreWorkplaceUseCase;
use App\Workplace\Entity\WorkplaceData;

class StoreWorkplaceUseCaseTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
        
        Artisan::call('migrate:fresh --seed');
    }

    /**
     * 作業場所新規登録のテスト
     *
     * @return void
     */
    public function test_作業場所を新規登録する(): void
    {
        $workplace_data = new WorkplaceData(null, 1, '永田町店', 100014, 
            13, '千代田区永田町1-7-1', '03-3581-3100');

        $use_case = new StoreWorkplaceUseCase();

        $use_case->handle($workplace_data, null);

        $this->assertDatabaseHas('workplaces', [
            'client_id' => $workplace_data->getClientId(),
            'name' => $workplace_data->getName(),
            'post_code' => $workplace_data->getPostCode(),
            'prefecture_id' => $workplace_data->getPrefectureId(),
            'address' => $workplace_data->getAddress(),
            'phone_number' => $workplace_data->getPhoneNumber(),
        ]);
    }
}
