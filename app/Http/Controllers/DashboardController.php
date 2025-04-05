<?php

// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Studio;
use App\Models\Booking;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function studios()
    {
        $studios = Studio::withCount('bookings')
                  ->withSum('bookings', 'total_harga')
                  ->orderBy('bookings_count', 'desc')
                  ->get();
        
        return view('dashboard.studios', compact('studios'));
    }

    public function dashboard()
{
    // Hitung total pelanggan
    $totalCustomer = User::count();
    
    // Ambil data booking dengan pagination
    $bookings = Booking::with('user')
        ->orderBy('created_at', 'desc')
        ->paginate(10); // Sesuaikan angka sesuai kebutuhan
    
    // Kirim semua variabel yang diperlukan ke view
    return view('dashboard.index', [
        'totalCustomer' => $totalCustomer,
        'recentBookings' => $bookings // Sesuaikan dengan nama variabel di view
    ]);
    
    // Atau bisa menggunakan compact():
    // return view('dashboard.index', compact('totalCustomer', 'bookings'));
}

    public function customers()
    {
        
        $customers = User::all(); // Jika menggunakan model Customer

        return view('dashboard.customers'); // Menampilkan view 'dashboard.customers'
    }
}
