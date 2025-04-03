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
        Schema::table('citizens', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();

            // Внешний ключ с каскадным удалением
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade'); // <--- Каскадное удаление
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citizens', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Удаление внешнего ключа
            $table->dropColumn('user_id'); // Удаление колонки
        });
    }
};
