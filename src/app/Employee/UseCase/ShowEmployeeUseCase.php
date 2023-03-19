<?php
namespace App\Employee\UseCase;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Employee;
use App\Traits\ModifyLengthAwarePaginator;

final class ShowEmployeeUseCase {

    use ModifyLengthAwarePaginator;
    /**
     * 従業員一覧を表示する
     *
     * @param string|null $search_keyword
     * @return LengthAwarePaginator
     */
    public function handle(?string $search_keyword): LengthAwarePaginator
    {
        $employees = Employee::select('id', 'contract_type_id', 'last_name', 'first_name', 'last_name_kana',
                'first_name_kana','post_code', 'prefecture_id', 'address', 'phone_number', 'email', 'birthday')
            ->SearchEmployeeByLastName($search_keyword)
            ->where('contract_type_id', '<=', \ContractTypeConstant::PART_TIME_JOB)
            ->orderBy('created_at', 'DESC')
            ->orderBy('id')
            ->with(['contractTypes:id,name', 'prefectures:id,name', 'employeeImages' => function($query) {
                $query->select('employee_id', 'path')->where('is_active', true);
            }])
            ->paginate(\PaginationConstant::NUMBER_PER_PAGE);

        return $this->postCodeIncludeDash($employees);
    }
}

