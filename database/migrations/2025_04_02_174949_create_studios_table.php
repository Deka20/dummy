<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('studios', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Nama studio
            $table->text('deskripsi')->nullable(); // Deskripsi opsional
            $table->integer('kapasitas'); // Kapasitas maksimal
            $table->decimal('harga_per_jam', 10, 2); // Harga sewa per jam
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('studios');
    }
};
