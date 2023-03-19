<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contract_type_id',
        'last_name',
        'first_name',
        'last_name_kana',
        'first_name_kana',
        'post_code',
        'prefecture_id',
        'address',
        'phone_number',
        'email',
        'birthday',
    ];

    /**
     * 雇用区分テーブルとのリレーション
     *
     * @return BelongsTo
     */
    public function contractTypes(): BelongsTo
    {
        return $this->belongsTo(ContractType::class, 'contract_type_id');
    }

    /**
     * 都道府県テーブルとのリレーション
     *
     * @return BelongsTo
     */
    public function prefectures(): BelongsTo
    {
        return $this->belongsTo(Prefecture::class, 'prefecture_id');
    }

    /**
     * 従業員イメージテーブルとのリレーション
     *
     * @return HasMay
     */
    public function employeeImages(): HasMany
    {
        return $this->hasMany(EmployeeImage::class);
    }

    /**
     * 従業員の氏名を取得
     *
     * @return Attribute
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->last_name . ' ' . $this->first_name,
        );
    }

    /**
     * 従業員の氏名(カタカナ)を取得
     *
     * @return Attribute
     */
    protected function fullNameKana(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->last_name_kana . ' ' . $this->first_name_kana,
        );
    }

    /**
     * 氏名で検索
     *
     * @param Builder $query
     * @param string|null $search_keyword
     * @return Builder
     */
    public function scopeSearchEmployeeByLastName(Builder $query, ?string $search_keyword): Builder
    {
        if (!empty($search_keyword)) {
            if (Employee::where('last_name', 'like', '%' .$search_keyword . '%')
                ->orWhere('first_name', 'like', '%' .$search_keyword . '%')
                ->exists()) {

                return $query->where('last_name', 'like', '%' . $search_keyword . '%')
                    ->orWhere('first_name', 'like', '%' . $search_keyword . '%');
            }
        }

        return $query;
    }
}
