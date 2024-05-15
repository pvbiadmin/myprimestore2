<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class GeneralSettingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'site_name' => $this->faker->name(),
            'site_layout' => $this->faker->word(),
            'contact_email' => $this->faker->unique()->safeEmail(),
            'currency_name' => $this->faker->name(),
            'currency_icon' => $this->faker->word(),
            'timezone' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'contact_phone' => $this->faker->phoneNumber(),
            'contact_address' => $this->faker->address(),
            'map' => $this->faker->word(),
        ];
    }
}
