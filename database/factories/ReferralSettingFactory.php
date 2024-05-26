<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;

class ReferralSettingFactory extends Factory
{
    #[ArrayShape([
        'bonus' => "float",
        'points' => "float",
        'created_at' => Carbon::class,
        'updated_at' => Carbon::class
    ])] public function definition(): array
    {
        return [
            'bonus' => $this->faker->randomFloat(),
            'points' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
