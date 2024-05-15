<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;

class FooterGridTwoFactory extends Factory
{
    #[ArrayShape([
        'name' => "string",
        'url' => "string",
        'status' => "bool",
        'created_at' => Carbon::class,
        'updated_at' => Carbon::class
    ])] public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'url' => $this->faker->url(),
            'status' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
