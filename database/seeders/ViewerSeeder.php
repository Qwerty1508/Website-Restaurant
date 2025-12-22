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
                'is_admin' => true, 
                'role' => 'viewer', 
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
    }
}