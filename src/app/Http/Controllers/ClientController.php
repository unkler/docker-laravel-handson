<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\Prefecture;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Client\UseCase\ShowClientUseCase;
use App\Client\UseCase\StoreClientUseCase;
use App\Client\UseCase\UpdateClientUseCase;
use App\Client\UseCase\DestroyClientUseCase;
use App\Client\Entity\ClientData;

class ClientController extends Controller
{
    /**
     * 一覧表示アクション
     *
     * @param Request $request
     * @param ShowClientUseCase $use_case
     * @return LengthAwarePaginator
    */
    public function index(Request $request, ShowClientUseCase $use_case): LengthAwarePaginator
    {
        return $use_case->handle($request->search_keyword);
    }

    /* 取引先取得アクション
    *
    * @param Request $request
    * @return Client
    */
    public function fetchClient(Request $request): Client
    {
        $employee = Client::select('id', 'name', 'post_code', 'prefecture_id', 'address', 'phone_number', 'email')
            ->find($request->id);

        return $employee;
    }

    /**
     * 都道府県取得アクション
     *
     * @return Collection
     */
    public function fetchPrefectures(): Collection
    {
        $prefectures = Prefecture::orderBy('id')
            ->pluck('name', 'id');
    
        return $prefectures;
    }

    /**
     * 新規保存アクション
     *
     * @param ClientRequest $request
     * @param StoreClientUseCase $use_case
     * @return integer
     */
    public function store(ClientRequest $request, StoreClientUseCase $use_case): int
    {
        $client_data = new ClientData(null, $request->name, $request->post_code, 
            $request->prefecture_id, $request->address, $request->phone_number, $request->email);

        return $use_case->handle($client_data);
    }

    /**
     * 更新アクション
     *
     * @param ClientRequest $request
     * @param UpdateClientUseCase $use_case
     * @return integer
     */
    public function update(ClientRequest $request, UpdateClientUseCase $use_case): int
    {
        $client_data = new ClientData($request->id, $request->name, $request->post_code, 
            $request->prefecture_id, $request->address, $request->phone_number, $request->email);

        return $use_case->handle($client_data);
    }

    /**
     * 削除アクション
     *
     * @param Request $request
     * @param DestroyClientUseCase $use_case
     * @return integer
     */
    public function destroy(Request $request, DestroyClientUseCase $use_case): int
    {
        return $use_case->handle($request->id);
    }
}
