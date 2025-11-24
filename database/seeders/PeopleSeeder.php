<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Person;
use App\Models\Contact;

class PeopleSeeder extends Seeder
{
    public function run(): void
    {
        Person::factory(10)->create()->each(function ($person) {

            Contact::factory(rand(1, 3))->create([
                'person_id' => $person->id
            ]);
        });
    }
}
