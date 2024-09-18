<?php

namespace Database\Seeders;

use App\Models\ChatThread;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatThreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChatThread::create([
            'student_id' => 1, // Replace with an existing student user ID
            'teacher_id' => 2, // Replace with an existing teacher user ID
            'admin_id' => 3,   // Optional: Replace with an existing admin user ID
        ]);
    }
}
