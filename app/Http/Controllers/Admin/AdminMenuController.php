<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Cloudinary\Configuration\Configuration;

class AdminMenuController extends Controller
{
    const DEFAULT_IMAGE = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400&h=300&fit=crop';

    public function __construct()
    {
        try {
            Configuration::instance('cloudinary://474775265674185:pI64ZhoDmEy2fhevZp-kqzzVuCE@dh9ysyfit');
        } catch (\Exception $e) {
        }
    }

    public function index()
    {
        $menus = DB::table('menus')->orderBy('created_at', 'desc')->get();
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:menus,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'image_url' => 'nullable|url',
        ], [
            'name.unique' => 'Menu dengan nama tersebut sudah ada. Silakan gunakan nama lain.',
        ]);

        $imageUrl = $request->image_url;

        if (empty($imageUrl)) {
            $imageUrl = self::DEFAULT_IMAGE;
        }

        DB::table('menus')->insert([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'image_url' => $imageUrl,
            'is_available' => $request->boolean('is_available', true),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/admin/menus')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit($slug)
    {
        $menu = DB::table('menus')->where('slug', $slug)->first();
        
        if (!$menu) {
            abort(404);
        }

        return view('admin.menus.edit', compact('menu'));
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'image_url' => 'nullable|url',
        ]);

        $menu = DB::table('menus')->where('slug', $slug)->first();
        
        if (!$menu) {
            abort(404);
        }

        $imageUrl = $request->image_url ?: $menu->image_url;

        DB::table('menus')->where('id', $menu->id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'image_url' => $imageUrl,
            'is_available' => $request->boolean('is_available', true),
            'updated_at' => now(),
        ]);

        return redirect('/admin/menus')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy($slug)
    {
        DB::table('menus')->where('slug', $slug)->delete();
        return redirect('/admin/menus')->with('success', 'Menu berhasil dihapus!');
    }
}
