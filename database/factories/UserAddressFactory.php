<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UserAddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomNumber(),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'country' => $this->faker->country(),
            'state' => $this->faker->word(),
            'city' => $this->faker->city(),
            'zip' => $this->faker->postcode(),
            'address' => $this->faker->address(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
