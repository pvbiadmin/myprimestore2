<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;

class CodSettingFactory extends Factory
{
    #[ArrayShape([
        'status' => "bool",
        'created_at' => Carbon::class,
        'updated_at' => Carbon::class
    ])] public function definition(): array
    {
        return [
            'status' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
