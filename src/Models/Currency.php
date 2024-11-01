<?php

namespace Muscobytes\Laravel\Takeads\Suite\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Muscobytes\Laravel\Takeads\Suite\Database\Factories\CurrencyFactory;


/**
 * TakeadsCountry
 *
 * @mixin Builder
 * @mixin Eloquent
 * @property int $id
 * @property string $code
 */
class Currency extends Model
{
    use HasFactory;


    protected $fillable = [
        'code'
    ];


    public function getTable(): string
    {
        return config('takeads.suite.table_prefix') . config('takeads.suite.table_names.currencies');
    }


    protected static function newFactory(): CurrencyFactory
    {
        return CurrencyFactory::new();
    }


    public function merchants(): HasMany
    {
        return $this->hasMany(
            related: Merchant::class
        );
    }


    public function coupons(): HasMany
    {
        return $this->hasMany(
            related: Coupon::class
        );
    }
}
