<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'John Doe',
            'designation' => 'Software Engineer',
            'duty' => 'Develop and maintain software applications',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password'), // Securely hash the password
            'note' => 'Hard-working and dedicated employee',
            'image' => 'https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=200',
            'level' => '1',
            'username' => 'johndoe',
            'role' => 'user', // Default role as 'user'
        ]);

        User::create([
            'name' => 'Jane Smith',
            'designation' => 'Project Manager',
            'duty' => 'Manage and oversee software projects',
            'email' => 'janesmith@example.com',
            'password' => Hash::make('password'), // Securely hash the password
            'note' => 'Excellent leadership and communication skills',
            'image' => 'https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=200',
            'level' => '2',
            'username' => 'janesmith',
            'role' => 'admin', // Assign role as 'admin'
        ]);
    }
}
