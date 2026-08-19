<?php

namespace Database\Factories;

use App\Models\District;
use App\Models\ZoneCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Zone>
 */
class ZoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->numberBetween(1, 1000),
            'district_id' => District::factory(),
            'zone_category_id' => ZoneCategory::factory(),
        ];
    }
}
