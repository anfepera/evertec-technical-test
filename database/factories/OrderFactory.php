<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'reference' => uniqid("ref-"),
            'customer_name' => $this->faker->name(),
            'customer_email' => $this->faker->unique()->safeEmail(),
            'customer_mobile' =>  $this->faker->phoneNumber(),
            'product_id' => Product::factory(),
            'status' => Order::STATUS_CREATED,
            'payment_url' => $this->faker->url,
            'transaction_id' => $this->faker->randomNumber(),
        ];
    }
}
