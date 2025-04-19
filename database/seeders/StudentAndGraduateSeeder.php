<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Juniorhighschool;
use App\Models\Graduate;
use Faker\Factory as Faker;

class StudentAndGraduateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_PH'); // Use Filipino locale for names

        // Create 100 male and 100 female students
        foreach (['Male', 'Female'] as $gender) {
            for ($i = 0; $i < 100; $i++) {
                Juniorhighschool::create([
                    'lrn_number' => $faker->unique()->numerify('##########'),
                    'first_name' => $faker->firstName($gender),
                    'middle_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'suffix' => $faker->randomElement(['Jr.', 'Sr.', 'II', 'III', '']),
                    'gender' => $gender,
                    'birthdate' => $faker->date(),
                    'address' => 'Magallanes, ' . $faker->streetAddress,
                    'school_year' => $faker->numberBetween(2010, 2024),
                    'photo_path' => null,
                ]);
            }
        }

        // Create 100 male and 100 female graduates
        foreach (['Male', 'Female'] as $gender) {
            for ($i = 0; $i < 100; $i++) {
                Graduate::create([
                    'ID_student' => $faker->unique()->numerify('##########'),
                    'first_name' => $faker->firstName($gender),
                    'middle_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'gender' => $gender,
                    'strand' => $faker->randomElement(['STEM', 'ABM', 'HUMSS', 'TVL']),
                    'year_graduated' => $faker->numberBetween(2010, 2024),
                ]);
            }
        }
    }
}
