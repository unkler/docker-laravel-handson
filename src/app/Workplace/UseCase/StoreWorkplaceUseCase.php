<?php
namespace App\Workplace\UseCase;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use App\Models\Workplace;
use App\Models\WorkplaceImage;
use App\Workplace\Entity\WorkplaceData;

final class StoreWorkplaceUseCase {

    /**
     * 作業場所を新規登録する
     *
     * @param WorkplaceData $workplace_data
     * @return integer
     */
    public function handle(WorkplaceData $workplace_data, ?UploadedFile $workplace_image): int
    {
        $response_code = Response::HTTP_CREATED;

        DB::beginTransaction();

        try {
            $workplace  = Workplace::create([
                'client_id' => $workplace_data->getClientId(),
                'name' => $workplace_data->getName(),
                'post_code' => $workplace_data->getPostCode(),
                'prefecture_id' => $workplace_data->getPrefectureId(),
                'address' => $workplace_data->getAddress(),
                'phone_number' => $workplace_data->getPhoneNumber(),
            ]);

            //画像保存処理
            if (isset($workplace_image)) {
                $file_path =   $workplace_image->store('public/workplaces');
                WorkplaceImage::create([
                    'path' =>   str_replace('public', '/storage', $file_path),
                    'workplace_id' => $workplace->id,
                    'is_active' => true,
                ]);
            }
            DB::commit();
        }catch(\Exception $e) {
            $response_code = Response::HTTP_INTERNAL_SERVER_ERROR;
            \Log::error('Workplace registration failed. ID = none');
            \Log::error($e->getMessage());
            DB::rollBack();
        }

        return $response_code;
    }
}

