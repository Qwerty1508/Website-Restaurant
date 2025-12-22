<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
        });
        $menus = \DB::table('menus')->get();
        foreach ($menus as $menu) {
            $slug = \Illuminate\Support\Str::slug($menu->name);
            \DB::table('menus')->where('id', $menu->id)->update(['slug' => $slug]);
        }
        Schema::table('menus', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->unique()->change();
        });
    }
    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};