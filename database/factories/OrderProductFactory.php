<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrderProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_name' => $this->faker->name(),
            'product_variant' => $this->faker->word(),
            'product_variant_price_total' => $this->faker->randomFloat(),
            'unit_price' => $this->faker->randomFloat(),
            'quantity' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'vendor_id' => Vendor::factory(),
        ];
    }
}
