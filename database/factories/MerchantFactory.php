<?php

namespace Muscobytes\Laravel\Takeads\Suite\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Muscobytes\Laravel\Takeads\Suite\Models\Category;
use Muscobytes\Laravel\Takeads\Suite\Models\Currency;
use Muscobytes\Laravel\Takeads\Suite\Models\Merchant;

class MerchantFactory extends Factory
{
    protected $model = Merchant::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'external_id' => $this->faker->numberBetween(100001, 999999),
            'name' => $this->faker->company(),
            'image_uri' => $this->faker->imageUrl(),
            'currency_id' => Currency::all()->random(),
            'default_domain' => $this->faker->domainName(),
            'domains' => json_encode(array_map(fn () => $this->faker->domainName, range(1, rand(1, 6)))),
            'category_id' => Category::all()->random(),
            'description' => $this->faker->text(),
            'is_active' => $this->faker->boolean(),
            'tracking_link' => $this->faker->url(),
        ];
    }
}
