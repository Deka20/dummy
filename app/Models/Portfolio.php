<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portfolio extends Model
{
    use HasFactory;

    protected $table = 'portfolios';
    protected $fillable = ['image_url', 'order'];

    /**
     * Get the properly formatted image URL
     *
     * @param string $value
     * @return string
     */
    public function getImageUrlAttribute($value)
    {
        // For debugging - output to log what's coming from the database
        Log::info('Original image_url value: ' . $value);
        
        if (!$value) {
            return asset('images/placeholder.jpg');
        }
        
        // If it's already a full URL
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }
        
        // If it starts with /storage
        if (str_starts_with($value, '/storage/')) {
            return $value;
        }
        
        // If it's a path stored from store() method
        return Storage::url($value);
    }
}