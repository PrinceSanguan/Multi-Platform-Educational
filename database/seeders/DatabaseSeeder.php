<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
        ]);

        $user->assignRole('super_admin');
    //     $user2 = \App\Models\User::factory()->create([
    //         'name' => 'teacher',
    //         'email' => 'teacher@admin.com',
    //     ]);

    //     $user2->assignRole('teacher');
    //     $user3 = \App\Models\User::factory()->create([
    //         'name' => 'student',
    //         'email' => 'student@admin.com',
    //     ]);

    //     $user3->assignRole('student');
    //     $user4 = \App\Models\User::factory()->create([
    //         'name' => 'parent',
    //         'email' => 'parent@admin.com',
    //     ]);

    //     $user4->assignRole('parent');
     }
}
