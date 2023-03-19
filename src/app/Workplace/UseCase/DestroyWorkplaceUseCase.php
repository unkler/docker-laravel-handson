<?php
namespace App\Workplace\UseCase;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Workplace;
use App\Models\WorkplaceImage;

final class DestroyWorkplaceUseCase {

    /**
     * 作業場所を論理削除する
     *
     * @param string $id
     * @return integer
     */
    public function handle(string $id): int
    {
        $response_code = Response::HTTP_OK;

        DB::beginTransaction();

        try {
            $client = Workplace::find($id);
            $client->delete();

            $registered_workplace_image = WorkplaceImage::where('workplace_id', $id)
                    ->where('is_active', true)
                    ->first();

            if (!is_null($registered_workplace_image)) {
                $registered_workplace_image->is_active = false;
                $registered_workplace_image->save();
            }

            DB::commit();
        }catch(\Exception $e) {
            $response_code = Response::HTTP_INTERNAL_SERVER_ERROR;
            \Log::error('Workplace deletion failed. ID = ' . $id);
            \Log::error($e->getMessage());
            DB::rollBack();
        }

        return $response_code;
    }
}

