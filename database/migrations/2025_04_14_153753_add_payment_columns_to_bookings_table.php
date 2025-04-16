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
            $table->string('payment_proof')->nullable()->after('status');
            $table->string('sender_account')->nullable()->after('payment_proof');
            $table->date('payment_date')->nullable()->after('sender_account');
            $table->timestamp('payment_uploaded_at')->nullable()->after('payment_date');
            $table->timestamp('expired_payment_at')->nullable()->after('payment_uploaded_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'payment_proof',
                'sender_account',
                'payment_date',
                'payment_uploaded_at',
                'expired_payment_at'
            ]);
        });
    }
};