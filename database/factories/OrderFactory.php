<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'invoice_id' => $this->faker->word(),
            'subtotal' => $this->faker->randomFloat(),
            'amount' => $this->faker->randomFloat(),
            'currency_name' => $this->faker->name(),
            'currency_icon' => $this->faker->word(),
            'product_quantity' => $this->faker->randomNumber(),
            'payment_method' => $this->faker->word(),
            'payment_status' => $this->faker->randomNumber(),
            'order_address' => $this->faker->address(),
            'shipping_method' => $this->faker->word(),
            'coupon' => $this->faker->word(),
            'order_status' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
