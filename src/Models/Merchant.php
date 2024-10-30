<?php

namespace Muscobytes\Laravel\Takeads\Suite\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Muscobytes\Laravel\Takeads\Suite\Database\Factories\MerchantFactory;


/**
 * TakeadsMerchant
 *
 * @mixin Builder
 * @mixin Eloquent
 * @property int $id
 * @property int $external_id
 * @property string $name
 * @property string $image_uri
 * @property string $currency_id
 * @property string $default_domain
 * @property string $domains
 * @property int $category_id
 * @property string $description
 * @property boolean $is_active
 * @property string $tracking_link
 */
class Merchant extends Model
{
    use HasFactory;


    protected $fillable = [
        'external_id',
        'name',
        'image_uri',
        'currency_id',
        'default_domain',
        'domains',
        'category_id',
        'description',
        'is_active',
        'tracking_link'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'domains' => 'json',
    ];


    public function getTable(): string
    {
        return config('takeads.suite.table_prefix') . config('takeads.suite.table_names.merchants');
    }


    protected static function newFactory(): MerchantFactory
    {
        return MerchantFactory::new();
    }


    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }


    public function countries(): BelongsToMany
    {
        return $this->BelongsToMany(Country::class, 'takeads_merchant_country', 'merchant_id', 'country_id');
    }


    public function coupons(): hasMany
    {
        return $this->hasMany(Coupon::class, 'merchant_id');
    }
}
