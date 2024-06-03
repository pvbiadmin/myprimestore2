<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;

class BrandFactory extends Factory
{
    #[ArrayShape([
        'logo' => "string",
        'name' => "string",
        'slug' => "string",
        'is_featured' => "bool",
        'status' => "bool",
        'created_at' => Carbon::class,
        'updated_at' => Carbon::class
    ])] public function definition(): array
    {
        return [
            'logo' => $this->faker->word(),
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'is_featured' => $this->faker->boolean(),
            'status' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
