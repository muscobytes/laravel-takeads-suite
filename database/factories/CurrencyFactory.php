<?php

namespace Muscobytes\Laravel\Takeads\Coupons\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Muscobytes\Laravel\Takeads\Coupons\Models\TakeadsCurrency;

/**
 * @extends Factory<TakeadsCurrency>
 */
class CurrencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TakeadsCurrency>
     */
    protected $model = TakeadsCurrency::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->unique()->currencyCode(),
        ];
    }
}
