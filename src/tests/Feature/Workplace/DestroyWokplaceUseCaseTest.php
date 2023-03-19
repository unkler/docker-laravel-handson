<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\Workplace;
use App\Workplace\UseCase\DestroyWorkplaceUseCase;

class DestroyWorkplaceUseCaseTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
        
        Artisan::call('migrate:fresh --seed');
    }

    /**
     * 作業場所削除のテスト
     *
     * @return void
     */
    public function test_作業場所を削除する(): void
    {
        $workplace = Workplace::create([
            'client_id' => 1,
            'name' => '永田町店',
            'post_code' => 1000014,
            'prefecture_id' => 13,
            'address' => '千代田区永田町1-7-1',
            'phone_number' => '03-3581-5111',
        ]);

        $use_case = new DestroyWorkplaceUseCase();

        $use_case->handle($workplace->id);

        $this->assertSoftDeleted('workplaces', [
            'id' => $workplace->id
        ]);
    }
}
