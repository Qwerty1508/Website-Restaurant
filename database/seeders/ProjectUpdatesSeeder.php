<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectUpdatesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('project_updates')->insert([
            [
                'title' => 'Navbar Enhancement',
                'description' => 'Perbaikan tampilan navbar untuk responsif di mobile. Menambahkan hamburger menu, memperbaiki spacing, dan animasi smooth untuk transisi.',
                'file_path' => 'resources/views/components/navbar.blade.php',
                'update_type' => 'modify',
                'update_date' => '2025-12-21',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'CSS App Updates',
                'description' => 'Update styling untuk luxury theme. Menambahkan variabel warna baru, glassmorphism effect, dan perbaikan responsive design.',
                'file_path' => 'public/css/app.css',
                'update_type' => 'modify',
                'update_date' => '2025-12-21',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Realtime Progress Sync',
                'description' => 'Menambahkan fitur sinkronisasi progress secara realtime antar device menggunakan database dan polling setiap 3 detik.',
                'file_path' => 'resources/views/project/index.blade.php',
                'update_type' => 'modify',
                'update_date' => '2025-12-21',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
