<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Isi migration
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->integer('durasi_jam')->after('waktu_reservasi')->default(1);
            $table->decimal('total_harga', 12, 2)->after('durasi_jam')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
};
