<?php

namespace Muscobytes\Laravel\Takeads\Suite\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Muscobytes\Laravel\Takeads\Suite\Database\Factories\CouponFactory;

/**
 * TakeadsCountry
 *
 * @mixin Builder
 * @mixin Eloquent
 * @property int $id
 * @property string $external_id
 * @property bool $is_active
 * @property string $tracking_link
 * @property string $name
 * @property string $code
 * @property int $merchant_id
 * @property TakeadsMerchant $merchant
 * @property string $image_uri
 * @property string $start_date
 * @property string $end_date
 * @property string $description
 * @property Collection<TakeadsCountry> $countries
 */
class TakeadsCoupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'is_active',
        'tracking_link',
        'name',
        'code',
        'merchant_id',
        'image_uri',
        'start_date',
        'end_date',
        'description'
    ];


    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];


    protected static function newFactory(): CouponFactory
    {
        return CouponFactory::new();
    }


    public function merchant(): BelongsTo
    {
        return $this->belongsTo(TakeadsMerchant::class, 'merchant_id', 'id');
    }


    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(TakeadsCategory::class, 'takeads_coupon_category', 'coupon_id', 'category_id');
    }


    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(TakeadsCountry::class, 'takeads_coupon_country', 'coupon_id', 'country_id');
    }


    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(TakeadsLanguage::class, 'takeads_coupon_language', 'coupon_id', 'language_id');
    }
}
