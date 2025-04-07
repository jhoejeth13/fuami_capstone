<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JHSTracerResponse;
use App\Models\TracerStudyResponse;
use Faker\Factory as Faker;

class TracerStudySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('en_PH'); // Using Philippines locale

        // Common data arrays
        $regions = ['REGION XIII', 'REGION XI', 'REGION X'];
        $provinces = ['AGUSAN DEL NORTE', 'SURIGAO DEL NORTE', 'DAVAO DEL NORTE'];
        $cities = ['BUTUAN CITY', 'SURIGAO CITY', 'TAGUM'];
        $barangays = ['Barangay 1', 'Barangay 2', 'Barangay 3', 'Barangay 4', 'Barangay 5'];
        $religions = ['Roman Catholic', 'Islam', 'Protestant', 'Evangelical', 'Iglesia ni Cristo'];
        $civilStatus = ['Single', 'Married', 'Widowed', 'Separated'];
        $organizationTypes = [
            'Government',
            'Private Company',
            'Non-Profit/NGO',
            'Educational Institution',
            'Healthcare',
            'Financial Services',
        ];
        $occupations = [
            'Teacher',
            'Office Staff',
            'Service Crew',
            'Sales Associate',
            'Factory Worker',
            'Customer Service Representative'
        ];
        $jobSituations = ['Regular', 'Contractual', 'Temporary', 'Part-time'];
        $yearsInCompany = ['Less than 1 year', '1-2 years', '2-3 years', '3-5 years'];
        $unemploymentReasons = [
            'Still studying',
            'Family concerns',
            'Health issues',
            'No job opportunities',
            'Lack of qualifications',
            'Personal choice'
        ];
        $shsTracks = ['ABM', 'HUMSS', 'STEM', 'TVL'];

        // Generate 100 employed JHS graduates
        for ($i = 0; $i < 100; $i++) {
            JHSTracerResponse::create([
                'graduate_type' => 'JHS',
                'first_name' => $faker->firstName,
                'middle_name' => $faker->optional(0.8)->lastName,
                'last_name' => $faker->lastName,
                'suffix' => $faker->optional(0.1)->randomElement(['Jr.', 'Sr.', 'III']),
                'age' => $faker->numberBetween(18, 30),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'birthdate' => $faker->dateTimeBetween('-30 years', '-18 years'),
                'civil_status' => $faker->randomElement($civilStatus),
                'religion' => $faker->randomElement($religions),
                'address' => $faker->streetAddress,
                'barangay' => $faker->randomElement($barangays),
                'municipality' => $faker->randomElement($cities),
                'province' => $faker->randomElement($provinces),
                'region' => $faker->randomElement($regions),
                'postal_code' => $faker->numberBetween(8000, 9000),
                'country' => 'Philippines',
                'year_graduated' => $faker->numberBetween(2015, 2023),
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'employment_status' => 'Employed',
                'employer_name' => $faker->company,
                'employer_address' => $faker->address,
                'organization_type' => $faker->randomElement($organizationTypes),
                'occupational_classification' => $faker->randomElement($occupations),
                'job_situation' => $faker->randomElement($jobSituations),
                'years_in_company' => $faker->randomElement($yearsInCompany),
                'unemployment_reason' => null,
            ]);
        }

        // Generate 100 unemployed JHS graduates
        for ($i = 0; $i < 100; $i++) {
            JHSTracerResponse::create([
                'graduate_type' => 'JHS',
                'first_name' => $faker->firstName,
                'middle_name' => $faker->optional(0.8)->lastName,
                'last_name' => $faker->lastName,
                'suffix' => $faker->optional(0.1)->randomElement(['Jr.', 'Sr.', 'III']),
                'age' => $faker->numberBetween(18, 30),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'birthdate' => $faker->dateTimeBetween('-30 years', '-18 years'),
                'civil_status' => $faker->randomElement($civilStatus),
                'religion' => $faker->randomElement($religions),
                'address' => $faker->streetAddress,
                'barangay' => $faker->randomElement($barangays),
                'municipality' => $faker->randomElement($cities),
                'province' => $faker->randomElement($provinces),
                'region' => $faker->randomElement($regions),
                'postal_code' => $faker->numberBetween(8000, 9000),
                'country' => 'Philippines',
                'year_graduated' => $faker->numberBetween(2015, 2023),
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'employment_status' => 'Unemployed',
                'employer_name' => null,
                'employer_address' => null,
                'organization_type' => null,
                'occupational_classification' => null,
                'job_situation' => null,
                'years_in_company' => null,
                'unemployment_reason' => $faker->randomElement($unemploymentReasons),
            ]);
        }

        // Generate 100 employed SHS graduates
        for ($i = 0; $i < 100; $i++) {
            TracerStudyResponse::create([
                'graduate_type' => 'SHS',
                'first_name' => $faker->firstName,
                'middle_name' => $faker->optional(0.8)->lastName,
                'last_name' => $faker->lastName,
                'suffix' => $faker->optional(0.1)->randomElement(['Jr.', 'Sr.', 'III']),
                'age' => $faker->numberBetween(18, 30),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'birthdate' => $faker->dateTimeBetween('-30 years', '-18 years'),
                'civil_status' => $faker->randomElement($civilStatus),
                'religion' => $faker->randomElement($religions),
                'address' => $faker->streetAddress,
                'barangay' => $faker->randomElement($barangays),
                'municipality' => $faker->randomElement($cities),
                'province' => $faker->randomElement($provinces),
                'region' => $faker->randomElement($regions),
                'postal_code' => $faker->numberBetween(8000, 9000),
                'country' => 'Philippines',
                'year_graduated' => $faker->numberBetween(2015, 2023),
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'employment_status' => 'Employed',
                'employer_name' => $faker->company,
                'employer_address' => $faker->address,
                'organization_type' => $faker->randomElement($organizationTypes),
                'occupational_classification' => $faker->randomElement($occupations),
                'job_situation' => $faker->randomElement($jobSituations),
                'years_in_company' => $faker->randomElement($yearsInCompany),
                'unemployment_reason' => null,
                'shs_track' => $faker->randomElement($shsTracks),
                'job_related_to_shs' => $faker->boolean,
                'fuami_factor' => $faker->boolean,
            ]);
        }

        // Generate 100 unemployed SHS graduates
        for ($i = 0; $i < 100; $i++) {
            TracerStudyResponse::create([
                'graduate_type' => 'SHS',
                'first_name' => $faker->firstName,
                'middle_name' => $faker->optional(0.8)->lastName,
                'last_name' => $faker->lastName,
                'suffix' => $faker->optional(0.1)->randomElement(['Jr.', 'Sr.', 'III']),
                'age' => $faker->numberBetween(18, 30),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'birthdate' => $faker->dateTimeBetween('-30 years', '-18 years'),
                'civil_status' => $faker->randomElement($civilStatus),
                'religion' => $faker->randomElement($religions),
                'address' => $faker->streetAddress,
                'barangay' => $faker->randomElement($barangays),
                'municipality' => $faker->randomElement($cities),
                'province' => $faker->randomElement($provinces),
                'region' => $faker->randomElement($regions),
                'postal_code' => $faker->numberBetween(8000, 9000),
                'country' => 'Philippines',
                'year_graduated' => $faker->numberBetween(2015, 2023),
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'employment_status' => 'Unemployed',
                'employer_name' => null,
                'employer_address' => null,
                'organization_type' => null,
                'occupational_classification' => null,
                'job_situation' => null,
                'years_in_company' => null,
                'unemployment_reason' => $faker->randomElement($unemploymentReasons),
                'shs_track' => $faker->randomElement($shsTracks),
                'job_related_to_shs' => null,
                'fuami_factor' => null,
            ]);
        }
    }
} 