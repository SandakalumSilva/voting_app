<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(DepartmentSeeder::class);

        User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678'),
            'department' => 'Admin Dept',
            'student_id' => 'ADMIN001',
            'profile_image' => 'default.png',
            'gender' => 'male',
            'role' => 'admin',
        ]);
    }
}
