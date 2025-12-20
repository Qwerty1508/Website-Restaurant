<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProjectController extends Controller
{
    public function index()
    {
        // Define the steps and their associated files
        $steps = [
            [
                'id' => 1,
                'user' => 'Edo',
                'role' => 'Project Lead & Core Backend',
                'description' => 'Foundation Setup: Authentication, User Model, Environment Config, and Base Routes.',
                'files' => [
                    'composer.json',
                    '.env.example',
                    'config/app.php',
                    'database/migrations/0001_01_01_000000_create_users_table.php',
                    'app/Models/User.php',
                    'routes/web.php',
                    'resources/views/layouts/guest.blade.php',
                ]
            ],
            [
                'id' => 2,
                'user' => 'Haidar',
                'role' => 'Backend Admin & Database',
                'description' => 'Admin Panel Implementation: Menu Management, Category Logic, and Admin Dashboard.',
                'files' => [
                    'database/migrations/2025_12_16_044137_create_menus_table.php',
                    'database/migrations/2025_12_17_151701_add_slug_to_menus_table.php',
                    'app/Models/Menu.php',
                    'resources/views/layouts/admin.blade.php',
                    'resources/views/admin/dashboard.blade.php',
                    'resources/views/admin/menus/create.blade.php', 
                    // Note: Ideally we would list the controller too if it exists, but sticking to key files.
                ]
            ],
            [
                'id' => 3,
                'user' => 'Dimas',
                'role' => 'Features & Customer Logic',
                'description' => 'Customer Features: Reservations, Orders, and Customer Dashboard.',
                'files' => [
                    'database/migrations/2025_12_16_053030_create_reservations_table.php',
                    'database/migrations/2025_12_18_000001_create_orders_table.php',
                    'app/Models/Reservation.php',
                    'app/Http/Controllers/ReservationController.php',
                    'app/Http/Controllers/OrderController.php',
                    'resources/views/reservation/create.blade.php',
                    'resources/views/customer/profile.blade.php',
                ]
            ],
            [
                'id' => 4,
                'user' => 'Bernard',
                'role' => 'Frontend UI & Public Pages',
                'description' => 'Public Interface: Landing Page, About, Contact, and Animations.',
                'files' => [
                    'resources/views/welcome.blade.php',
                    'resources/views/about.blade.php',
                    'resources/views/contact.blade.php',
                    'resources/views/components/navbar.blade.php',
                    'public/css/app.css',
                ]
            ],
        ];

        // Process files to read content
        foreach ($steps as &$step) {
            $step['file_contents'] = [];
            foreach ($step['files'] as $filePath) {
                // Determine absolute path
                $absolutePath = base_path($filePath);
                
                if (File::exists($absolutePath)) {
                    $content = File::get($absolutePath);
                    $step['file_contents'][] = [
                        'path' => $filePath,
                        'content' => $content,
                        'exists' => true
                    ];
                } else {
                    $step['file_contents'][] = [
                        'path' => $filePath,
                        'content' => "// File not found in current project directory: $filePath",
                        'exists' => false
                    ];
                }
            }
        }

        return view('project.index', compact('steps'));
    }
}
