<?php
namespace App\Client\UseCase;

use Illuminate\Http\Response;
use App\Models\Client;

final class DestroyClientUseCase {

    /**
     * 取引先を論理削除する
     *
     * @param string $id
     * @return integer
     */
    public function handle(string $id): int
    {
        $response_code = Response::HTTP_OK;

        try {
            $client = Client::find($id);
            $client->delete();
        }catch(\Exception $e) {
            $response_code = Response::HTTP_INTERNAL_SERVER_ERROR;
            \Log::error('Client deletion failed. ID = ' . $id);
            \Log::error($e->getMessage());
        }

        return $response_code;
    }
}

