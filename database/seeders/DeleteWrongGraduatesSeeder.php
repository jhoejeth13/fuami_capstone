<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeleteWrongGraduatesSeeder extends Seeder
{
    public function run()
    {
        // Delete records where ID_student starts with 'JHS' or 'SHS'
        DB::table('graduates')
            ->where('ID_student', 'like', 'JHS%')
            ->orWhere('ID_student', 'like', 'SHS%')
            ->delete();
    }
} 