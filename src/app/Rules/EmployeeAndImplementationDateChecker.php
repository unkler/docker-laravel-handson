<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\TaskAssign;

class EmployeeAndImplementationDateChecker implements Rule
{

    /**
     * Create a new rule instance.
     *
     * @param array $employee_ids
     * @param string $implementation_date
     * @return void
     */
    public function __construct(
        private array $employee_ids,
        private string $implementation_date)
    {
        $this->employee_ids = $employee_ids;
        $this->implementation_date = $implementation_date;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $not_duplicate = true;
        foreach($this->employee_ids as $employee_id) {
            $is_exist =TaskAssign::where('implementation_date', $this->implementation_date)
                ->whereHas('employeeTaskAssigns', function ($query) use ($employee_id) {
                    $query->where('employee_id', $employee_id);
                })
                ->exists();

            if ($is_exist) $not_duplicate = false;
        }
        return $not_duplicate;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '指定の担当者は' . $this->implementation_date . 'に割り当て済みです';
    }
}
