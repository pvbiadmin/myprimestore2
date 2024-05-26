<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;

class CommissionFactory extends Factory
{
    #[ArrayShape([
        'user_id' => "int",
        'referral' => "float",
        'unilevel' => "float",
        'created_at' => Carbon::class,
        'updated_at' => Carbon::class
    ])] public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomNumber(),
            'referral' => $this->faker->randomFloat(),
            'unilevel' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
