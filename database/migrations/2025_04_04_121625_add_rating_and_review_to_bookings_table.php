<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_add_rating_and_review_to_bookings_table.php
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->tinyInteger('rating')->nullable();
            $table->text('review')->nullable();
            $table->timestamp('reviewed_at')->nullable();
        });
    }
    

public function down()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropColumn(['rating', 'review', 'reviewed_at']);
    });
}
};
