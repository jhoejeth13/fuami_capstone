<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeleteWrongJHSSeeder extends Seeder
{
    public function run()
    {
        // Delete records where school_year contains a hyphen (e.g., "2021-2022")
        DB::table('juniorhighschool')
            ->where('school_year', 'like', '%-%')
            ->delete();
    }
} 