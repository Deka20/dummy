<?php

// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Studio;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function show(Studio $studio)
{
    $reviews = Booking::with('user')
                ->where('studio_id', $studio->id)
                ->whereNotNull('review')
                ->whereNotNull('rating')
                ->latest('reviewed_at')
                ->paginate(5);

    $averageRating = Booking::where('studio_id', $studio->id)
                    ->whereNotNull('rating')
                    ->avg('rating');

    $ratingsDistribution = [];
    for ($i = 1; $i <= 5; $i++) {
        $ratingsDistribution[$i] = Booking::where('studio_id', $studio->id)
                                ->where('rating', $i)
                                ->count();
    }

    $totalReviews = array_sum($ratingsDistribution);

    // Gunakan kolom yang sudah ada (misalnya updated_at)
    $confirmedOrdersCount = Booking::where('status', 'confirmed')
                           ->where('user_id', Auth::id())
                           ->where('updated_at', '>', now()->subDay()) // Pesanan dikonfirmasi dalam 1 hari terakhir
                           ->count();
    
    return view('index', compact(
        'studio',
        'reviews',
        'averageRating',
        'ratingsDistribution',
        'totalReviews',
        'confirmedOrdersCount'
    ));
}

    public function allReviews()
{
    $allReviews = Booking::whereNotNull('review')
        ->whereNotNull('rating')
        ->with(['user', 'studio'])
        ->orderBy('reviewed_at', 'desc')
        ->paginate(10);

    return view('reviews.index', compact('allReviews'));
}    

}
