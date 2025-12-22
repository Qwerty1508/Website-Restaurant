<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ViewerSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'test@'],
            [
                'name' => 'Viewer Account',
                'email' => 'test@',
                'password' => Hash::make('test'),
                'is_admin' => true, // Allow access to admin pages
                'role' => 'viewer', // But readonly
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
    }
}
