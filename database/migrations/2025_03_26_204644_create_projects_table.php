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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->date('published_at')->nullable();
            $table->boolean('active')->default(false);
            $table->string('type')->nullable();
            $table->longText('introtext')->nullable();
            $table->longText('content')->nullable();
            $table->string('image', 255)->nullable();
            $table->longText('blocks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
