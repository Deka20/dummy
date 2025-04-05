<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Booking;

class Studio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 
        'deskripsi', 
        'kapasitas', 
        'harga_per_jam',
        'cover_studio'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // app/Models/Studio.php
    // Studio.php
    public function reviews()
    {
        return $this->hasMany(Booking::class)
            ->whereNotNull('review')
            ->whereNotNull('rating');
    }
}