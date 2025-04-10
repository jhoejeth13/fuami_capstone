<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Make sure you import the User model

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a user using the User model
        User::create([
            'name' => 'John Doe',  // Name of the user
            'email' => 'john@example.com',  // Email of the user
            'password' => bcrypt('password123')  // Hashed password (make sure to hash the password)
        ]);
    }
}
