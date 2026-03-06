<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'license_plate' => $this->generateLicensePlate(),
            'is_default' => false,
            'is_foreign' => false,
            'vehicle_category_id' => $this->faker->randomElement([1, 2, 3, 4])
        ];
    }

    private function generateLicensePlate(): string
    {
        $letters = ['А', 'В', 'Е', 'К', 'М', 'Н', 'О', 'Р', 'С', 'Т', 'У', 'Х'];

        $letter1 = $this->faker->randomElement($letters);
        $number  = $this->faker->numberBetween(1, 999);
        $letter2 = $this->faker->randomElement($letters);
        $letter3 = $this->faker->randomElement($letters);
        $region  = $this->faker->numberBetween(1, 999);

        $num_str   = str_pad($number,   3, '0', STR_PAD_LEFT);
        $region_str = str_pad($region, 3, '0', STR_PAD_LEFT);

        return $letter1 . $num_str . $letter2 . $letter3 . $region_str;
    }
}
