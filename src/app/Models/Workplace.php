<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Workplace extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'name',
        'post_code',
        'prefecture_id',
        'address',
        'phone_number',
    ];

    /**
     * 取引先テーブルとのリレーション
     *
     * @return BelongsTo
     */
    public function clients(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
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
     * 作業場所イメージテーブルとのリレーション
     *
     * @return HasMay
     */
    public function workplaceImages(): HasMany
    {
        return $this->hasMany(WorkplaceImage::class);
    }

    /**
     * 住所を取得
     *
     * @return Attribute
     */
    public function fullAddress(): Attribute
    {
        $prefecture = Prefecture::find($this->prefecture_id);

        return Attribute::make(
            get: fn () => $prefecture->name . '' . $this->address,
        );
    }

    /**
     * 作業場所で検索
     *
     * @param Builder $query
     * @param string|null $search_keyword
     * @return Builder
     */
    public function scopeSearchWorkplaceByName(Builder $query, ?string $search_keyword): Builder
    {
        if (!empty($search_keyword)) {
            if (Workplace::where('name', 'like', '%' .$search_keyword . '%')->exists()) {
                return $query->where('name', 'like', '%' . $search_keyword . '%');
            }
        }

        return $query;
    }
}
