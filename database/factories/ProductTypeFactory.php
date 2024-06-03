<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;

class ProductTypeFactory extends Factory
{
    #[ArrayShape([
        'name' => "string",
        'slug' => "string",
        'is_package' => "bool",
        'status' => "bool",
        'created_at' => Carbon::class,
        'updated_at' => Carbon::class,
        'degree' => "int"
    ])] public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'is_package' => $this->faker->boolean(),
            'status' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'degree' => $this->faker->randomNumber(),
        ];
    }
}
