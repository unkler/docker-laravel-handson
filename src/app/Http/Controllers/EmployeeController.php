<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\Employee;
use App\Models\ContractType;
use App\Models\Prefecture;
use App\Http\Requests\EmployeeRequest;
use App\Employee\UseCase\ShowEmployeeUseCase;
use App\Employee\UseCase\StoreEmployeeUseCase;
use App\Employee\UseCase\UpdateEmployeeUseCase;
use App\Employee\UseCase\DestroyEmployeeUseCase;
use App\Employee\Entity\EmployeeData;
use App\Traits\StringConverter;

class EmployeeController extends Controller
{
    use StringConverter;

    /**
     * 一覧表示アクション
     *
     * @param Request $request
     * @param ShowEmployeeUseCase $use_case
     * @return LengthAwarePaginator
     */
    public function index(Request $request, ShowEmployeeUseCase $use_case): LengthAwarePaginator
    {
        return $use_case->handle($request->search_keyword);
    }

    /**
     * 従業員取得アクション
     *
     * @param Request $request
     * @return Employee
     */
    public function fetchEmployee(Request $request): Employee
    {
        $employee = Employee::select('id', 'contract_type_id', 'last_name', 'first_name', 'last_name_kana', 'first_name_kana',
                'post_code', 'prefecture_id', 'address', 'phone_number', 'email', 'birthday')
            ->with(['employeeImages' => function($query) {
                $query->select('employee_id', 'path')->where('is_active', true);
            }])
            ->find($request->id);
    
        return $employee;
    }

    /**
     * 従業員種別取得アクション
     *
     * @return Collection
     */
    public function fetchContractTypes(): Collection
    {
        $contract_types = ContractType::where('id', '<=', \ContractTypeConstant::TEMPORARY_RETIREMENT)
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
     * @param EmployeeRequest $request
     * @param StoreEmployeeUseCase $use_case
     * @return integer
     */
    public function store(EmployeeRequest $request, StoreEmployeeUseCase $use_case): int
    {
        $employee_data = new EmployeeData(null, $request->contract_type_id, $request->last_name,$request->first_name,
            $request->last_name_kana, $request->first_name_kana, $request->post_code, $request->prefecture_id,
            $request->address, $request->phone_number, $request->email, $request->birthday);

        return $use_case->handle($employee_data, $request->file('profile_image'));
    }

    /**
     * 更新アクション
     *
     * @param EmployeeRequest $request
     * @param UpdateEmployeeUseCase $use_case
     * @return integer
     */
    public function update(EmployeeRequest $request, UpdateEmployeeUseCase $use_case): int
    {
        $employee_data = new EmployeeData($request->id, $request->contract_type_id, $request->last_name,$request->first_name,
            $request->last_name_kana, $request->first_name_kana, $request->post_code, $request->prefecture_id,
            $request->address, $request->phone_number, $request->email, $request->birthday);

        return $use_case->handle($employee_data, $request->file('profile_image'), 
            $this->toBoolean($request->is_delete_registered_image));
    }

    /**
     * 削除アクション
     *
     * @param Request $request
     * @param DestroyEmployeeCase $use_case
     * @return integer
     */
    public function destroy(Request $request, DestroyEmployeeUseCase $use_case): int
    {
        return $use_case->handle($request->id);
    }
}
