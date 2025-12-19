<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'name' => 'Rendang Sapi Premium',
                'description' => 'Daging sapi pilihan dengan bumbu rempah khas Padang.',
                'price' => 85000,
                'image_url' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=400&h=300&fit=crop',
                'category' => 'Lauk Pauk',
                'is_available' => true,
            ],
            [
                'name' => 'Nasi Goreng Spesial',
                'description' => 'Nasi goreng dengan telur, ayam, dan sayuran segar.',
                'price' => 45000,
                'image_url' => 'https://images.unsplash.com/photo-1569058242567-93de6f36f8e6?w=400&h=300&fit=crop',
                'category' => 'Nasi & Mie',
                'is_available' => true,
            ],
            [
                'name' => 'Sate Ayam Madura',
                'description' => '10 tusuk sate dengan bumbu kacang dan lontong.',
                'price' => 55000,
                'image_url' => 'https://images.unsplash.com/photo-1562967916-eb82221dfb44?w=400&h=300&fit=crop',
                'category' => 'Lauk Pauk',
                'is_available' => true,
            ],
            [
                'name' => 'Mie Goreng Jawa',
                'description' => 'Mie goreng dengan bumbu kecap manis khas Jawa.',
                'price' => 42000,
                'image_url' => 'https://images.unsplash.com/photo-1476224203421-9ac39bcb3327?w=400&h=300&fit=crop',
                'category' => 'Nasi & Mie',
                'is_available' => true,
            ],
            [
                'name' => 'Gado-gado Jakarta',
                'description' => 'Salad sayuran dengan bumbu kacang lezat.',
                'price' => 35000,
                'image_url' => 'https://images.unsplash.com/photo-1563379926898-05f4575a45d8?w=400&h=300&fit=crop',
                'category' => 'Lauk Pauk',
                'is_available' => true,
            ],
            [
                'name' => 'Ayam Bakar Taliwang',
                'description' => 'Ayam bakar dengan bumbu pedas khas Lombok.',
                'price' => 65000,
                'image_url' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=400&h=300&fit=crop',
                'category' => 'Lauk Pauk',
                'is_available' => true,
            ],
            [
                'name' => 'Es Teh Manis',
                'description' => 'Teh manis segar dengan es batu.',
                'price' => 15000,
                'image_url' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=400&h=300&fit=crop',
                'category' => 'Minuman',
                'is_available' => true,
            ],
            [
                'name' => 'Es Cendol Durian',
                'description' => 'Cendol segar dengan topping durian.',
                'price' => 25000,
                'image_url' => 'https://images.unsplash.com/photo-1551024506-0bccd828d307?w=400&h=300&fit=crop',
                'category' => 'Dessert',
                'is_available' => true,
            ],
        ];

        foreach ($menus as $menu) {
            DB::table('menus')->updateOrInsert(
                ['name' => $menu['name']],
                array_merge($menu, [
                    'slug' => \Illuminate\Support\Str::slug($menu['name']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
