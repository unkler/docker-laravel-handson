<?php
namespace App\Client\UseCase;

use Illuminate\Http\Response;
use App\Models\Client;
use App\Client\Entity\ClientData;

final class UpdateClientUseCase {

    /**
     * 取引先を更新する
     *
     * @param ClientData $client_data
     * @return integer
     */
    public function handle(ClientData $client_data): int
    {
        $response_code = Response::HTTP_CREATED;

        $client = Client::find($client_data->getId());

        $client->name = $client_data->getName();
        $client->post_code = $client_data->getPostCode();
        $client->prefecture_id = $client_data->getPrefectureId();
        $client->address = $client_data->getAddress();
        $client->phone_number = $client_data->getPhoneNumber();
        $client->email = $client_data->getEmail();

        try {
            $client->save();
        }catch(\Exception $e) {
            $response_code = Response::HTTP_INTERNAL_SERVER_ERROR;
            \Log::error('Client modification failed. ID = ' . $client->id);
            \Log::error($e->getMessage());
        }

        return $response_code;
    }
}

