<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PaypalSettingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'status' => $this->faker->boolean(),
            'mode' => $this->faker->boolean(),
            'country' => $this->faker->country(),
            'currency_name' => $this->faker->name(),
            'currency_icon' => $this->faker->word(),
            'currency_rate' => $this->faker->randomFloat(),
            'client_id' => $this->faker->word(),
            'secret_key' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
