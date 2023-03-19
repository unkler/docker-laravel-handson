<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Workplace;
use App\Workplace\UseCase\UpdateWorkplaceUseCase;
use App\Workplace\Entity\WorkplaceData;

class UpdateWorkplaceUseCaseTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
        
        Artisan::call('migrate:fresh --seed');
    }

    /**
     * 作業場所更新のテスト
     *
     * @return void
     */
    public function test_作業場所を更新する(): void
    {
        $workplace = Workplace::create([
            'client_id' => 1,
            'name' => '永田町店',
            'post_code' => 1000014,
            'prefecture_id' => 13,
            'address' => '千代田区永田町1-7-1',
            'phone_number' => '03-3581-5111',
        ]);

        $workplace_data = new WorkplaceData($workplace->id, 2, '大手前店', 5408570, 
        27, '大阪市中央区大手前２丁目 大阪府庁本館１階', '06-6944-8371');

        $use_case = new UpdateWorkplaceUseCase();

        $use_case->handle($workplace_data, null, false);

        $this->assertDatabaseHas('workplaces', [
            'id' => $workplace_data->getId(),
            'client_id' => $workplace_data->getClientId(),
            'name' => $workplace_data->getName(),
            'post_code' => $workplace_data->getPostCode(),
            'prefecture_id' => $workplace_data->getPrefectureId(),
            'address' => $workplace_data->getAddress(),
            'phone_number' => $workplace_data->getPhoneNumber(),
        ]);
    }
}
