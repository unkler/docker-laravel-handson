<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class TaskAssign extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'workplace_id',
        'implementation_date'
    ];

     /**
     * 従業員作業中間テーブルとのリレーション
     *
     * @return HasMany
     */
    public function employeeTaskAssigns(): HasMany
    {
        return $this->hasMany(EmployeeTaskAssign::class);
    }

    /**
     * 従業員テーブルとのリレーション
     *
     * @return HasManyThrough
     */
    public function employees(): HasManyThrough
    {
        return $this->hasManyThrough(Employee::class, EmployeeTaskAssign::class, 'task_assign_id', 'id', 'id', 'employee_id');
    }

    /**
     * 作業場所テーブルとのリレーション
     *
     * @return BelongsTo
     */
    public function workplaces(): BelongsTo
    {
        return $this->belongsTo(Workplace::class, 'workplace_id');
    }

    /**
     * 住所で検索
     *
     * @param Builder $query
     * @param string|null $search_keyword
     * @return Builder
     */
    public function scopeSearchWorkplaceByAddress(Builder $query, ?string $search_keyword): Builder
    {
        if (!empty($search_keyword)) {
            if (Workplace::where('address', 'like', '%' .$search_keyword . '%')->exists()) {
                return $query->where('address', 'like', '%' . $search_keyword . '%');
            }
        }

        return $query;
    }
}
