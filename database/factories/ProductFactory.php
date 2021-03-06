<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'product_name' => $this->faker->name(),
            'price' => $this->faker->randomNumber(4),
        ];
    }
}
