<?php

namespace Muscobytes\Laravel\Takeads\Suite\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Muscobytes\Laravel\Takeads\Suite\Database\Factories\ActionFactory;

/**
 * TakeadsAction
 *
 * @mixin Builder
 * @mixin Eloquent
 * @property int $id
 * @property string $external_id
 * @property int $external_numeric_id
 * @property string $adspace_id
 * @property int $merchant_id
 * @property BelongsTo $merchant
 * @property string $program_id
 * @property string $status
 * @property string $sub_id
 * @property float $order_amount
 * @property float $publisher_revenue
 * @property int $currency_id
 * @property BelongsTo $currency
 * @property string $type
 * @property DateTimeInterface $order_date
 * @property DateTimeInterface $remote_created_at
 * @property DateTimeInterface $remote_updated_at
 * @property int $country_id
 * @property string $click_id
 * @property string $coupon_id
 */
class Action extends Model
{
    use HasFactory;

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


    public function getTable(): string
    {
        return config('takeads.suite.table_prefix') . config('takeads.suite.table_names.actions');
    }


    protected static function newFactory(): string
    {
        return ActionFactory::class;
    }


    public function merchant(): BelongsTo
    {
        return $this->belongsTo(
            related: Merchant::class,
            foreignKey: 'merchant_id',
            ownerKey: 'id',
            relation: 'merchant'
        );
    }


    public function currency(): BelongsTo
    {
        return $this->belongsTo(
            related: Currency::class,
            foreignKey: 'currency_id',
            ownerKey: 'id',
            relation: 'currency'
        );
    }
}
