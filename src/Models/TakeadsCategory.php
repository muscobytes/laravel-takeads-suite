<?php

namespace Muscobytes\Laravel\Takeads\Suite\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Muscobytes\Laravel\Takeads\Suite\Database\Factories\CategoryFactory;


/**
 * TakeadsCountry
 *
 * @mixin Builder
 * @mixin Eloquent
 * @property int $id
 * @property int $external_id
 */
class TakeadsCategory extends Model
{
    use HasFactory;


    protected $fillable = [
        'external_id'
    ];


    public static function getTableName(): string
    {
        return config('takeads.suite.table_prefix') . config('takeads.suite.table_names.categories');
    }


    public function coupons(): BelongsToMany
    {
        return $this->belongsToMany(
            related: TakeadsCoupon::class,
            table: 'takeads_coupon_category',
            foreignPivotKey: 'category_id',
            relatedPivotKey: 'coupon_id'
        );
    }


    public function merchants(): BelongsTo
    {
        return $this->belongsTo(
            related: TakeadsMerchant::class,
            foreignKey: 'category_id'
        );
    }
}
