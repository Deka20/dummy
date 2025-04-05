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
        Schema::table('bookings', function (Blueprint $table) {
            // Hapus foreign key yang ada untuk user_id
            $table->dropForeign(['user_id']);  // Hapus foreign key yang ada

            // Tambahkan foreign key baru dengan onDelete('cascade')
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Hapus foreign key untuk user_id
            $table->dropForeign(['user_id']);

            // Kembalikan foreign key tanpa onDelete cascade
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
};
