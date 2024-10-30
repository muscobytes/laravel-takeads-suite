<?php

namespace Muscobytes\Laravel\Takeads\Suite\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Muscobytes\Laravel\Takeads\Suite\Models\Action;
use Muscobytes\Laravel\Takeads\Suite\Models\Country;

/**
 * @extends Factory<Country>
 */
class ActionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Action>
     */
    protected $model = Action::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }
}
