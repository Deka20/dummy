<?php

// app/Models/Booking.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $casts = [
        'tanggal_reservasi' => 'date',
        'waktu_reservasi' => 'datetime',
        'reviewed_at' => 'datetime',
        'payment_date' => 'date',
        'payment_uploaded_at' => 'datetime',
        'expired_payment_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
        ];

    protected $fillable = [
        'user_id',
        'studio_id',
        'tanggal_reservasi',
        'waktu_reservasi',
        'durasi_jam',
        'jumlah_pelanggan',
        'total_harga',
        'status',
        'rating',
        'review',
        'reviewed_at',
        'booking_id',
        'payment_proof',
        'sender_account',
        'payment_date',
        'payment_uploaded_at',
        'expired_payment_at',
    ];

    public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}


    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    public function updatePaymentProof(array $attributes)
{
    return $this->update(array_merge($attributes, [
        'payment_uploaded_at' => now(),
        'status' => 'waiting_verification'
    ]));
}

    
}