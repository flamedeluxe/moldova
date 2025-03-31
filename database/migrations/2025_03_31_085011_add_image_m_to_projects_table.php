<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('banner', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('image_m', 255)->nullable();
            $table->string('image_back', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('banner');
            $table->dropColumn('slug');
            $table->dropColumn('image_m');
            $table->dropColumn('image_back');
        });
    }
};
