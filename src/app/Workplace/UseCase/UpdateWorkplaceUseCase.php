<?php
namespace App\Workplace\UseCase;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use App\Models\Workplace;
use App\Models\WorkplaceImage;
use App\Workplace\Entity\WorkplaceData;

final class UpdateWorkplaceUseCase {

    /**
     * 作業場所を更新する
     *
     * @param WorkplaceData $workplace_data
     * @param UploadedFile|null $profile_image
     * @param bool $is_delete_registered_image
     * @return integer
     */
    public function handle(WorkplaceData $workplace_data, ?UploadedFile $workplace_image, bool $is_delete_registered_image): int
    {
        $response_code = Response::HTTP_CREATED;

        $workplace = Workplace::find($workplace_data->getId());

        $workplace->client_id = $workplace_data->getClientId();
        $workplace->name = $workplace_data->getName();
        $workplace->post_code = $workplace_data->getPostCode();
        $workplace->prefecture_id = $workplace_data->getPrefectureId();
        $workplace->address = $workplace_data->getAddress();
        $workplace->phone_number = $workplace_data->getPhoneNumber();

        DB::beginTransaction();

        try {
            $workplace->save();

            // イメージ画像はis_activeがtrueのレコードが1つのみ存在する仕様のため
            // 削除や更新されている場合、既に登録されているレコードはfalseに変更する
            if($is_delete_registered_image) {
                $registered_workplace_image = WorkplaceImage::where('workplace_id', $workplace->id)
                    ->where('is_active', true)
                    ->first();
                
                if (!is_null($registered_workplace_image)) {
                    $registered_workplace_image->is_active = false;
                    $registered_workplace_image->save();
                }
            }

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
            \Log::error('Workplace modification failed. ID = ' . $workplace->id);
            \Log::error($e->getMessage());
            DB::rollBack();
        }

        return $response_code;
    }
}

