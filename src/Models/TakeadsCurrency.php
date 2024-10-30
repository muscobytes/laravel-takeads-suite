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
class TakeadsCurrency extends Model
{
    use HasFactory;


    protected $fillable = [
        'code'
    ];


    public static function getTableName(): string
    {
        return config('takeads.suite.table_prefix') . config('takeads.suite.table_names.currencies');
    }


    public function merchants(): HasMany
    {
        return $this->hasMany(
            related: TakeadsMerchant::class
        );
    }


    public function coupons(): HasMany
    {
        return $this->hasMany(
            related: TakeadsCoupon::class
        );
    }
}
