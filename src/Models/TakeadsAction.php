<?php

namespace Muscobytes\Laravel\Takeads\Suite\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * TakeadsAction
 *
 * @mixin Builder
 * @mixin Eloquent
 * @property $id
 * @property $external_id
 * @property $external_numeric_id
 * @property $adspace_id
 * @property $merchant_id
 * @property $program_id
 * @property $status
 * @property $sub_id
 * @property $order_amount
 * @property $publisher_revenue
 * @property $currency_id
 * @property $type
 * @property $order_date
 * @property $remote_created_at
 * @property $remote_updated_at
 * @property $country_id
 * @property $click_id
 * @property $coupon_id
 */
class TakeadsAction extends Model
{
    use HasFactory;

    protected $table = 'takeads_actions';

    protected $fillable = [
        'external_id',
        'external_numeric_id',
        'adspace_id',
        'merchant_id',
        'program_id',
        'status',
        'sub_id',
        'order_amount',
        'publisher_revenue',
        'currency_id',
        'type',
        'order_date',
        'remote_created_at',
        'remote_updated_at',
        'country_id',
        'click_id',
        'coupon_id'
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'remote_created_at' => 'datetime',
        'remote_updated_at' => 'datetime',
    ];


    public function merchant(): BelongsTo
    {
        return $this->belongsTo(
            related: TakeadsMerchant::class,
            foreignKey: 'merchant_id',
            ownerKey: 'id',
            relation: 'merchant'
        );
    }


    public function currency(): BelongsTo
    {
        return $this->belongsTo(
            related: TakeadsCurrency::class,
            foreignKey: 'currency_id',
            ownerKey: 'id',
            relation: 'currency'
        );
    }
}
