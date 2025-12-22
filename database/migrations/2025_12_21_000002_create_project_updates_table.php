<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_updates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('file_path');
            $table->string('update_type')->default('modify');
            $table->date('update_date');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('project_updates');
    }
};