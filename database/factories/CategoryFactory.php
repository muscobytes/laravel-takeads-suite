<?php

namespace Muscobytes\Laravel\Takeads\Coupons\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Muscobytes\Laravel\Takeads\Coupons\Models\TakeadsCategory;
use Muscobytes\Laravel\Takeads\Coupons\Models\TakeadsCountry;

/**
 * @extends Factory<TakeadsCountry>
 */
class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TakeadsCategory>
     */
    protected $model = TakeadsCategory::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'external_id' => fake()->unique()->randomNumber(),
        ];
    }
}