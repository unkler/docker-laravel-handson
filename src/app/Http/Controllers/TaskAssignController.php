<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\TaskAssign;
use App\Models\Employee;
use App\Models\Client;
use App\Models\Workplace;
use App\Http\Requests\TaskAssignRequest;
use App\TaskAssign\Entity\TaskAssignData;
use App\TaskAssign\UseCase\ShowTaskAssignUseCase;
use App\TaskAssign\UseCase\StoreTaskAssignUseCase;
use App\TaskAssign\UseCase\UpdateTaskAssignUseCase;
use App\TaskAssign\UseCase\DestroyTaskAssignUseCase;

class TaskAssignController extends Controller
{
    /**
     * 一覧表示アクション
     *
     * @param ShowTaskAssignUseCase $use_case
     * @return LengthAwarePaginator
     */
    public function index(Request $request, ShowTaskAssignUseCase $use_case): LengthAwarePaginator
    {
        return $use_case->handle($request->is_after_today);
    }

    /**
     * 取引先と作業場所取得アクション
     *
     * @param Request $request
     * @return Client
     */
    public function fetchClientsWithWorkplaces(): Collection
    {
        $clients = Client::has('workplaces')
            ->with(['workplaces'])
            ->get();

        return $clients;
    }

    /**
     * 従業員取得アクション
     *
     * @return Collection
     */
    public function fetchEmployees(): Collection
    {
        $employees = Employee::select('id', 'first_name', 'last_name')
            ->orderBy('created_at')
            ->get();
    
        return $employees;
    }

    /**
     * 作業場所取得アクション
     *
     * @return Workplace
     */
    public function fetchWorkplace(Request $request): Workplace
    {
        $workplace = Workplace::select('id', 'client_id', 'name', 'post_code', 'prefecture_id', 'address', 'phone_number')
            ->with(['clients:id,name', 'prefectures:id,name', 'workplaceImages:path,workplace_id,is_active'])
            ->find($request->workplace_id);
    
        return $workplace;
    }

    /**
     * 新規保存アクション
     *
     * @param TaskAssignRequest $request
     * @param StoreTaskAssignUseCase $use_case
     * @return integer
     */
    public function store(TaskAssignRequest $request, StoreTaskAssignUseCase $use_case): int
    {
        $task_assign_data = new TaskAssignData(null, $request->workplace_id, 
            $request->employee_ids, $request->implementation_date);

        return $use_case->handle($task_assign_data);
    }

    /**
     * 作業取得アクション
     *
     * @param Request $request
     * @return TaskAssign
     */
    public function fetchTaskAssign(Request $request): TaskAssign
    {
        $task_assign = TaskAssign::select('id', 'workplace_id', 'implementation_date')
            ->with('employees:id,last_name,first_name')
            ->find($request->id);

        return $task_assign;
    }

    /**
     * 更新アクション
     *
     * @param TaskAssignRequest $request
     * @param UpdateTaskAssignUseCase $use_case
     * @return integer
     */
    public function update(TaskAssignRequest $request, UpdateTaskAssignUseCase $use_case): int
    {
        $task_assign_data = new TaskAssignData($request->id, $request->workplace_id, 
            $request->employee_ids, $request->implementation_date);

        return $use_case->handle($task_assign_data);
    }

    /**
     * 削除アクション
     *
     * @param Request $request
     * @param DestroyTaskAssignUseCase $use_case
     * @return integer
     */
    public function destroy(Request $request, DestroyTaskAssignUseCase $use_case): int
    {
        return $use_case->handle($request->id);
    }
}
