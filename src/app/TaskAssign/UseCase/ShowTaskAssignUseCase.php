<?php
namespace App\TaskAssign\UseCase;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\TaskAssign;

final class ShowTaskAssignUseCase {

    /**
     *  作業一覧を表示する
     *
     * @param string $is_after_today
     * @return LengthAwarePaginator
     */
    public function handle(string $is_after_today): LengthAwarePaginator
    {
        $condition = $is_after_today === 'true' ? '>=' : '<';

        $task_assigns = TaskAssign::select('id', 'workplace_id', 'implementation_date')->with('workPlaces', 'employees', 'workplaces.clients:id,name')
            ->where('implementation_date', $condition,  Carbon::today()->format('Y-m-d'))
            ->groupBy(['workplace_id', 'implementation_date'])
            ->paginate(\PaginationConstant::NUMBER_PER_PAGE);

        return $task_assigns;
    }
}

