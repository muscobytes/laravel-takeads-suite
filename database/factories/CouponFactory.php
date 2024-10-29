<?php

namespace Muscobytes\Laravel\Takeads\Coupons\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Muscobytes\Laravel\Takeads\Coupons\Models\TakeadsCoupon;
use Muscobytes\Laravel\Takeads\Coupons\Models\TakeadsMerchant;

class CouponFactory extends Factory
{
    protected $model = TakeadsCoupon::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'external_id' => $this->faker->regexify('[A-Za-z0-9]{21}'),
            'tracking_link' => $this->faker->url(),
            'name' => $this->faker->words(rand(1, 5), true),
            'code' => $this->faker->optional($weight = 40)->regexify('[A-Za-z0-9]{6,10}'),
            'merchant_id' => TakeadsMerchant::factory()->create(),
            'image_uri' => $this->faker->imageUrl(),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'description' => $this->faker->text(),
        ];
    }
}
