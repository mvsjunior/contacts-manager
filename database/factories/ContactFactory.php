<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Person;

class ContactFactory extends Factory
{
    public function definition(): array
    {
        $countryCodes = ['1', '44', '33', '49', '351', '55', '81'];

        return [
            'person_id'    => Person::factory(),
            'country_code' => $this->faker->randomElement($countryCodes),
            'number'       => $this->faker->numerify('#########')
        ];
    }
}
