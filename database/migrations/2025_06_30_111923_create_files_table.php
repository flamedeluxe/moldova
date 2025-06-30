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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Название файла
            $table->string('original_name')->nullable(); // Оригинальное название файла
            $table->string('path'); // Путь к файлу
            $table->string('url')->nullable(); // Ссылка на файл
            $table->string('mime_type')->nullable(); // Тип файла
            $table->bigInteger('size')->nullable(); // Размер файла в байтах
            $table->string('extension')->nullable(); // Расширение файла
            $table->text('description')->nullable(); // Описание файла
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
