<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('studio_id')->constrained();
            $table->integer('jumlah_pelanggan');
            $table->date('tanggal_reservasi');
            $table->time('waktu_reservasi');
            $table->string('status')->default('pending');
            $table->string('total_harga');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
