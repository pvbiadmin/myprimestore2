<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'thumb_image' => $this->faker->word(),
            'subcategory_id' => $this->faker->randomNumber(),
            'child_category_id' => $this->faker->randomNumber(),
            'quantity' => $this->faker->randomNumber(),
            'short_description' => $this->faker->text(),
            'long_description' => $this->faker->text(),
            'video_link' => $this->faker->word(),
            'sku' => $this->faker->word(),
            'price' => $this->faker->randomFloat(),
            'points' => $this->faker->randomFloat(),
            'offer_price' => $this->faker->randomFloat(),
            'offer_start_date' => $this->faker->word(),
            'offer_end_date' => $this->faker->word(),
            'product_type' => $this->faker->word(),
            'status' => $this->faker->randomNumber(),
            'is_approved' => $this->faker->randomNumber(),
            'seo_title' => $this->faker->word(),
            'seo_description' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'vendor_id' => Vendor::factory(),
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
        ];
    }
}
