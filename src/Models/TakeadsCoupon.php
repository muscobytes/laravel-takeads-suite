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
use Muscobytes\TakeadsApi\Dto\V1\Monetize\V1\CouponSearch\CouponDto;

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


    public static function getTableName(): string
    {
        return config('takeads.suite.table_prefix') . config('takeads.suite.table_names.coupons');
    }


    public function merchant(): BelongsTo
    {
        return $this->belongsTo(
            related: TakeadsMerchant::class,
            foreignKey: 'merchant_id',
            ownerKey: 'id'
        );
    }


    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            related: TakeadsCategory::class,
            table: config('takeads.suite.table_prefix') . config('takeads.suite.table_names.coupon_category'),
            foreignPivotKey: 'coupon_id',
            relatedPivotKey: 'category_id'
        );
    }


    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(
            related: TakeadsCountry::class,
            table: config('takeads.suite.table_prefix') . config('takeads.suite.table_names.coupon_country'),
            foreignPivotKey: 'coupon_id',
            relatedPivotKey: 'country_id'
        );
    }


    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(
            related: TakeadsLanguage::class,
            table: config('takeads.suite.table_prefix') . config('takeads.suite.table_names.coupon_language'),
            foreignPivotKey: 'coupon_id',
            relatedPivotKey: 'language_id'
        );
    }


    public static function updateOrCreateFromDto(CouponDto $couponDto): self
    {
        $coupon = self::updateOrCreate([
            'external_id' => $couponDto->couponId
        ], [
            'is_active' => true,
            'tracking_link' => $couponDto->trackingLink,
            'name' => $couponDto->name,
            'code' => $couponDto->code,
            'merchant_id' => TakeadsMerchant::firstOrCreate([
                'external_id' => $couponDto->merchantId
            ], [
                'is_active' => true,
            ])->id,
            'image_uri' => $couponDto->imageUri,
            'start_date' => $couponDto->startDate,
            'end_date' => $couponDto->endDate,
            'description' => $couponDto->description,
        ]);

        $coupon->languages()->attach(array_map(
            fn ($languageCode) => TakeadsLanguage::firstOrCreate([
                'code' => $languageCode
            ])->id,
            $couponDto->languageCodes
        ));

        $coupon->countries()->attach(array_map(
            fn ($countryId) => TakeadsCountry::firstOrCreate([
                'code' => $countryId
            ])->id,
            $couponDto->countryCodes
        ));

        $coupon->categories()->attach(array_map(
            fn ($categoryId) => TakeadsCategory::firstOrCreate([
                'external_id' => $categoryId
            ])->id,
            $couponDto->categoryIds
        ));

        return $coupon;
    }
}
