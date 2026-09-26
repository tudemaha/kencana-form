<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $school = School::create([
            'name' => 'Admin Test School',
            'address' => '123 Admin St',
        ]);

        User::create([
            'name' => 'Super Admin',
            'username' => 'admin',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'school_id' => $school->id,
        ]);
    }
}
