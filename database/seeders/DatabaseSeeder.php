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
            'name' => 'Admin School (DO NOT DELETE)',
            'address' => '123 Admin St',
        ]);

        User::create([
            'name' => 'Super Admin',
            'username' => config('app.admin.username'),
            'password' => bcrypt((string) config('app.admin.password')),
            'role' => 'admin',
            'school_id' => $school->id,
        ]);
    }
}
