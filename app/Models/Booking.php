<?php

// app/Models/Booking.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $casts = [
        'tanggal_reservasi' => 'date',
        'waktu_reservasi' => 'datetime',
        'reviewed_at' => 'datetime'
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
        'booking_id'
    ];

    public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}


    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    
}