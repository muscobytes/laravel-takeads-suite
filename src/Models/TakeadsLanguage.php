<?php

namespace Muscobytes\Laravel\Takeads\Coupons\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Muscobytes\Laravel\Takeads\Coupons\Database\Factories\LanguageFactory;


/**
 * TakeadsCountry
 *
 * @mixin Builder
 * @mixin Eloquent
 */
class TakeadsLanguage extends Model
{
    use HasFactory;

    protected $table = 'takeads_languages';

    protected $fillable = [
        'code'
    ];


    protected static function newFactory(): LanguageFactory
    {
        return LanguageFactory::new();
    }


    public function coupons(): BelongsToMany
    {
        return $this->belongsToMany(TakeadsCoupon::class, 'takeads_coupon_language');
    }
}
