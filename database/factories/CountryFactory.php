<?php

namespace Muscobytes\Laravel\Takeads\Suite\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Muscobytes\Laravel\Takeads\Suite\Models\TakeadsCountry;

/**
 * @extends Factory<TakeadsCountry>
 */
class CountryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TakeadsCountry>
     */
    protected $model = TakeadsCountry::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->unique()->countryCode(),
        ];
    }
}
