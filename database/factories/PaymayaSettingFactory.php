<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;

class PaymayaSettingFactory extends Factory
{
    #[ArrayShape([
        'status' => "bool",
        'name' => "string",
        'number' => "string",
        'created_at' => Carbon::class,
        'updated_at' => Carbon::class])
    ] public function definition(): array
    {
        return [
            'status' => $this->faker->boolean(),
            'name' => $this->faker->name(),
            'number' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
