<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    /**
     * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
     */
    public function definition()
    {
        return [
            'plate_number' => strtoupper(fake()
                    ->randomLetter()).fake()
                    ->numberBetween(100, 999),
        ];
    }
}
