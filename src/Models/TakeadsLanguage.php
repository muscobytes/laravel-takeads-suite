<?php

namespace Muscobytes\Laravel\Takeads\Suite\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Muscobytes\Laravel\Takeads\Suite\Database\Factories\LanguageFactory;


/**
 * TakeadsCountry
 *
 * @mixin Builder
 * @mixin Eloquent
 */
class TakeadsLanguage extends Model
{
    use HasFactory;


    protected $fillable = [
        'code'
    ];


    public static function getTableName(): string
    {
        return config('takeads.suite.table_prefix') . config('takeads.suite.table_names.languages');
    }


    public function coupons(): BelongsToMany
    {
        return $this->belongsToMany(TakeadsCoupon::class, 'takeads_coupon_language');
    }
}
