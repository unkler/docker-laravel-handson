<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'post_code',
        'prefecture_id',
        'address',
        'phone_number',
        'email',
    ];

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
     * 作業場所テーブルとのリレーション
     *
     * @return BelongsTo
     */
    public function workplaces(): HasMany
    {
        return $this->hasMany(Workplace::class);
    }

    /**
     * 取引先名で検索
     *
     * @param Builder $query
     * @param string|null $search_keyword
     * @return Builder
     */
    public function scopeSearchClientBytName(Builder $query, ?string $search_keyword): Builder
    {
        if (!empty($search_keyword)) {
            if (Client::where('name', 'like', '%' .$search_keyword . '%')->exists()) {
                return $query->where('name', 'like', '%' . $search_keyword . '%');
            }
        }

        return $query;
    }
}
