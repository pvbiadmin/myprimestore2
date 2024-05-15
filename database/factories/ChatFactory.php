<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ChatFactory extends Factory
{
    public function definition(): array
    {
        return [
            'message' => $this->faker->word(),
            'seen' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'sender_id' => User::factory(),
            'receiver_id' => User::factory(),
        ];
    }
}
