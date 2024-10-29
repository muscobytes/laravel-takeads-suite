<?php

namespace Muscobytes\Laravel\Takeads\Suite\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Muscobytes\Laravel\Takeads\Suite\Database\Factories\CountryFactory;


/**
 * TakeadsCountry
 *
 * @mixin Builder
 * @mixin Eloquent
 * @property int $id
 * @property string $code
 */
class TakeadsCountry extends Model
{
    use HasFactory;


    protected $table = 'takeads_countries';

    protected $fillable = [
        'code'
    ];


    protected static function newFactory(): CountryFactory
    {
        return CountryFactory::new();
    }


    public function coupons(): BelongsToMany
    {
        return $this->belongsToMany(TakeadsCoupon::class, 'takeads_coupon_country');
    }
}
