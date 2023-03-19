<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\TaskAssign;
use App\Rules\WorkplaceAndImplementationDateChecker;
use App\Rules\EmployeeAndImplementationDateChecker;

class TaskAssignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'workplace_id' => ['required', 'integer', 'exists:workplaces,id'],
            'employee_ids' => ['array'],
            'employee_ids.*' => ['required', 'integer', 'exists:employees,id'],
            'implementation_date' => ['required', 'string', 'date_format:Y-m-d', 'after_or_equal:today',
                new WorkplaceAndImplementationDateChecker($this->workplace_id, $this->implementation_date),
                new EmployeeAndImplementationDateChecker($this->employee_ids, $this->implementation_date)
            ],
        ];
    }

    /**
     * 項目名
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'workplace_id' => '作業場所',
            'employee_ids' => '担当者',
            'employee_ids.*' => '担当者',
        ];
    }

    /**
     * バリーデーション前の整形処理
     *
     * @return void
     */
    // protected function prepareForValidation()
    // {
    //     if(!is_array($this->employee_ids)) {
    //         $this->employee_ids = explode(',', $this->employee_ids);
    //     }
    //     // dd($this->employee_ids);
    // }
}
