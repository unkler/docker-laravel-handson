<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\Workplace;
use App\Models\Client;
use App\Models\Prefecture;
use App\Http\Requests\WorkplaceRequest;
use App\Workplace\UseCase\ShowWorkplaceUseCase;
use App\Workplace\UseCase\StoreWorkplaceUseCase;
use App\Workplace\UseCase\UpdateWorkplaceUseCase;
use App\Workplace\UseCase\DestroyWorkplaceUseCase;
use App\Workplace\Entity\WorkplaceData;
use App\Traits\StringConverter;

class WorkplaceController extends Controller
{
    use StringConverter;

    /**
     * 一覧表示アクション
     *
     * @param Request $request
     * @param ShowWorkplaceUseCase $use_case
     * @return LengthAwarePaginator
    */
    public function index(Request $request, ShowWorkplaceUseCase $use_case): LengthAwarePaginator
    {
        return $use_case->handle($request->search_keyword);
    }

    /**
     * 作業場所取得アクション
     *
     * @param Request $request
     * @return Workplace
     */
    public function fetchWorkplace(Request $request): Workplace
    {
        $workplace = Workplace::select('id', 'client_id', 'name', 'post_code', 'prefecture_id', 'address', 'phone_number')
            ->with(['workplaceImages' => function($query) {
                $query->select('workplace_id', 'path')->where('is_active', true);
            }])
            ->find($request->id);

        return $workplace;
    }

    /**
     * 取引先取得アクション
     *
     * @return Collection
     */
    public function fetchClients(): Collection
    {
        $contract_types = Client::orderBy('created_at', 'DESC')
            ->orderBy('id')
            ->pluck('name', 'id');
    
        return $contract_types;
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
     * @param WorkplaceRequest $request
     * @param StoreWorkplaceUseCase $use_case
     * @return integer
     */
    public function store(WorkplaceRequest $request, StoreWorkplaceUseCase $use_case): int
    {
        $workplace_data = new WorkplaceData(null, $request->client_id, $request->name,
            $request->post_code, $request->prefecture_id, $request->address, $request->phone_number);

        return $use_case->handle($workplace_data, $request->file('workplace_image'));
    }


    // TODO 2/27 下記の更新と削除の画像ありの場合に変更する。画像アップロード時の圧縮ライブラリ適用する。


    /**
     * 更新アクション
     *
     * @param WorkplaceRequest $request
     * @param UpdateWorkplaceUseCase $use_case
     * @return integer
     */
    public function update(WorkplaceRequest $request, UpdateWorkplaceUseCase $use_case): int
    {
        $workplace_data = new WorkplaceData($request->id, $request->client_id, $request->name,
            $request->post_code, $request->prefecture_id, $request->address, $request->phone_number);

        return $use_case->handle($workplace_data, $request->file('workplace_image'),
            $this->toBoolean($request->is_delete_registered_image));
    }

    /**
     * 削除アクション
     *
     * @param Request $request
     * @param DestroyWorkplaceUseCase $use_case
     * @return integer
     */
    public function destroy(Request $request, DestroyWorkplaceUseCase $use_case): int
    {
        return $use_case->handle($request->id);
    }
}
