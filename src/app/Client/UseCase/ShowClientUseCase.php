<?php
namespace App\Client\UseCase;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Client;
use App\Traits\ModifyLengthAwarePaginator;

final class ShowClientUseCase {

    use ModifyLengthAwarePaginator;

    /**
     * 取引先一覧を表示する
     *
     * @param string|null $search_keyword
     * @return LengthAwarePaginator
     */
    public function handle(?string $search_keyword): LengthAwarePaginator
    {
        $clients = Client::select('id', 'name', 'post_code', 'prefecture_id', 'address', 'phone_number', 'email')
            ->SearchClientBytName($search_keyword)
            ->orderBy('created_at', 'DESC')
            ->orderBy('id')
            ->with(['prefectures:id,name'])
            ->paginate(\PaginationConstant::NUMBER_PER_PAGE);

        return $this->postCodeIncludeDash($clients);
    }
}

