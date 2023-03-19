<?php
namespace App\Client\UseCase;

use Illuminate\Http\Response;
use App\Models\Client;
use App\Client\Entity\ClientData;

final class StoreClientUseCase {

    /**
     * 取引先を新規登録する
     *
     * @param ClientData $client_data
     * @return integer
     */
    public function handle(ClientData $client_data): int
    {
        $response_code = Response::HTTP_CREATED;

        try {
            Client::create([
                'name' => $client_data->getName(),
                'post_code' => $client_data->getPostCode(),
                'prefecture_id' => $client_data->getPrefectureId(),
                'address' => $client_data->getAddress(),
                'phone_number' => $client_data->getPhoneNumber(),
                'email' => $client_data->getEmail()
            ]);
        }catch(\Exception $e) {
            $response_code = Response::HTTP_INTERNAL_SERVER_ERROR;
            \Log::error('Client registration failed. ID = none');
            \Log::error($e->getMessage());
        }

        return $response_code;
    }
}

