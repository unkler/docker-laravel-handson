<?php
namespace App\Workplace\UseCase;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Workplace;
use App\Traits\ModifyLengthAwarePaginator;

final class ShowWorkplaceUseCase {

    use ModifyLengthAwarePaginator;

    /**
     * 作業場所一覧を表示する
     *
     * @param string|null $search_keyword
     * @return LengthAwarePaginator
     */
    public function handle(?string $search_keyword): LengthAwarePaginator
    {
        $workplaces = Workplace::select('id', 'client_id', 'name', 'post_code',
                'prefecture_id', 'address', 'phone_number')
            ->SearchWorkplaceByName($search_keyword)
            ->orderBy('created_at', 'DESC')
            ->orderBy('id')
            ->with(['clients:id,name', 'prefectures:id,name', 'workplaceImages' => function($query) {
                $query->select('workplace_id', 'path')->where('is_active', true);
            }])
            ->paginate(\PaginationConstant::NUMBER_PER_PAGE);

        return $this->postCodeIncludeDash($workplaces);
    }
}

