<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;

class PointTransactionFactory extends Factory
{
    #[ArrayShape(['user_id' => "int", 'type' => "string", 'points' => "float", 'created_at' => "\Illuminate\Support\Carbon", 'updated_at' => "\Illuminate\Support\Carbon"])] public function definition()
    {
        return [
            'user_id' => $this->faker->randomNumber(),
            'type' => $this->faker->word(),
            'points' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
