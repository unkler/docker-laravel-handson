<?php
namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;

trait ModifyLengthAwarePaginator
{
    /**
     * ページネーションインスンタンスのpost_codeにハイフンを追加する
     *
     * @param LengthAwarePaginator $length_aware_paginates
     * @return LengthAwarePaginator
     */
    public function postCodeIncludeDash(LengthAwarePaginator $length_aware_paginates): LengthAwarePaginator
    {
        $modified_length_aware_paginates = 
            $length_aware_paginates->getCollection()->transform(function($length_aware_paginate) {
                $length_aware_paginate->post_code = 
                    substr($length_aware_paginate->post_code, 0, 3) . '-' . substr($length_aware_paginate->post_code, 3);
                return $length_aware_paginate;
            });

        return $length_aware_paginates->setCollection($modified_length_aware_paginates);
    }
}