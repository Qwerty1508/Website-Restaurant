<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ProjectUpdatesSeeder extends Seeder
{
    public function run(): void
    {
        $updates = [
            [
                'title' => 'feat: Add comprehensive mobile responsiveness CSS fixes',
                'description' => 'Added 338 lines of mobile CSS for all pages including contact, about, menu, reservation, and dashboard',
                'file_path' => 'public/css/app.css',
                'update_type' => 'feature',
                'update_date' => '2025-12-21',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'fix: How To Order desktop bug - cards clipped on sides',
                'description' => 'Wrapped 100vw styles in mobile-only media query to prevent desktop overflow',
                'file_path' => 'public/css/app.css',
                'update_type' => 'fix',
                'update_date' => '2025-12-21',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'fix: How To Order desktop scroll - add overflow hidden',
                'description' => 'Added overflow hidden to luxury-card-wrapper to contain glow effect',
                'file_path' => 'public/css/app.css',
                'update_type' => 'fix',
                'update_date' => '2025-12-21',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'chore: Complete project comment cleanup',
                'description' => 'Removed all comments from navbar.blade.php, ProjectController.php, cloudinary-upload.js, app.css',
                'file_path' => 'Multiple files',
                'update_type' => 'chore',
                'update_date' => '2025-12-21',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'fix: About section scroll issue - add overflow hidden',
                'description' => 'Added overflow-hidden to video container and repositioned experience badge',
                'file_path' => 'resources/views/welcome.blade.php',
                'update_type' => 'fix',
                'update_date' => '2025-12-22',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'feat: Add glassmorphism effect to experience badge',
                'description' => 'Badge now uses same CSS variables as navbar for consistent glass effect',
                'file_path' => 'public/css/app.css',
                'update_type' => 'feature',
                'update_date' => '2025-12-22',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('project_updates')->insert($updates);
    }
}