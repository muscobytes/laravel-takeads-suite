<?php

namespace Muscobytes\Laravel\Takeads\Coupons\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Muscobytes\Laravel\Takeads\Coupons\Database\Factories\CategoryFactory;


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


    protected $table = 'takeads_categories';

    protected $fillable = [
        'external_id'
    ];


    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }


    public function coupons(): BelongsToMany
    {
        return $this->belongsToMany(TakeadsCoupon::class, 'takeads_coupon_country');
    }


    public function merchants(): BelongsTo
    {
        return $this->belongsTo(TakeadsMerchant::class, 'category_id');
    }
}
