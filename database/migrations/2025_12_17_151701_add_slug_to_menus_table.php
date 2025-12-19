<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
        });

        // Backfill existing menus
        $menus = \DB::table('menus')->get();
        foreach ($menus as $menu) {
            $slug = \Illuminate\Support\Str::slug($menu->name);
            // Ensure uniqueness for existing data manually if needed, 
            // but for now assuming names are unique enough or just basic slug
            \DB::table('menus')->where('id', $menu->id)->update(['slug' => $slug]);
        }

        Schema::table('menus', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
