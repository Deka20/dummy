<?php

// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Studio;
use App\Models\Booking;
use App\Models\Pelanggan;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function studios()
    {
        $studios = Studio::withCount('bookings')
                  ->withSum('bookings', 'total_harga')
                  ->orderBy('bookings_count', 'desc')
                  ->get();

        $newOrdersCount = Booking::where('status', 'pending')->count();
        
        return view('dashboard.studios', [
            'studios' => $studios,
            'newOrdersCount' => $newOrdersCount,
        ]);
    }

    public function dashboard()
{
    // Hitung total pelanggan
    $totalCustomer = User::count();
    
    $newOrdersCount = Booking::whereIn('status', ['pending', 'waiting_verification'])->count();
    
    // Ambil data booking terbaru dengan pagination
    $recentBookings = Booking::with('user')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        $unverifiedPaymentsCount = Booking::where('status', 'waiting_verification')->count();
    
    return view('dashboard.index', [
        'totalCustomer' => $totalCustomer,
        'newOrdersCount' => $newOrdersCount,
        'recentBookings' => $recentBookings,
        'unverifiedPaymentsCount' => $unverifiedPaymentsCount
    ]);
}

    public function customers()
    {
        
        $customers = User::all(); // Jika menggunakan model Customer
        $newOrdersCount = Booking::where('status', 'pending')->count();

        return view('dashboard.customers', [
            'newOrdersCount' => $newOrdersCount,
        ]); // Menampilkan view 'dashboard.customers'
    }

    public function settings()
    {
        // Fetch portfolio items ordered by their display order
        $portfolioItems = Portfolio::orderBy('order')->get();
        $newOrdersCount = Booking::where('status', 'pending')->count();
        
        return view('dashboard.settings', [
            'portfolioItems' => $portfolioItems,
            'newOrdersCount' => $newOrdersCount,
        ]);
    }

    // In PortfolioController.php, modify the save method:

public function save(Request $request)
{
    $validator = Validator::make($request->all(), [
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'order' => 'nullable|integer|min:1',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Store the image in the storage/app/public/portfolio directory
    $imagePath = $request->file('image')->store('portfolio', 'public');
    
    // Determine order if not provided
    if (!$request->filled('order')) {
        $maxOrder = Portfolio::max('order') ?? 0;
        $order = $maxOrder + 1;
    } else {
        $order = $request->order;
        
        // If order already exists, shift other items down
        Portfolio::where('order', '>=', $order)
            ->increment('order');
    }

    // Create portfolio item with just the path (not the full URL)
    Portfolio::create([
        'image_url' => $imagePath, // This will be like "portfolio/filename.jpg"
        'order' => $order,
    ]);

    return redirect()->back()->with('success', 'Image uploaded successfully!');
}

    /**
     * Delete a portfolio image
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $portfolioItem = Portfolio::findOrFail($id);
        
        // Delete the image file from storage
        $path = str_replace('/storage/', '', $portfolioItem->image_url);
        Storage::disk('public')->delete($path);
        
        // Delete the database record
        $portfolioItem->delete();
        
        // Reorder remaining items to prevent gaps
        $this->reorderAfterDeletion($portfolioItem->order);

        return redirect()->back()->with('success', 'Image deleted successfully!');
    }

    /**
     * Update the order of portfolio items
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:portfolios,id',
            'items.*.order' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update each item's order
        foreach ($request->items as $item) {
            Portfolio::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully!'
        ]);
    }

    /**
     * Reorder items after deletion to prevent gaps
     *
     * @param  int  $deletedOrder
     * @return void
     */
    private function reorderAfterDeletion($deletedOrder)
    {
        // Decrease order value for all items that were after the deleted item
        Portfolio::where('order', '>', $deletedOrder)
            ->decrement('order');
    }

    public function payments()
{
    $bookings = Booking::whereNotNull('payment_proof')
                ->with(['user', 'studio'])
                ->latest()
                ->paginate(10);

    $unverifiedPaymentsCount = Booking::where('status', 'waiting_verification')->count();

    return view('dashboard.payments', compact('bookings', 'unverifiedPaymentsCount'));
}

public function verifyPayment(Booking $booking)
{
    $booking->update(['status' => 'confirmed']);
    return back()->with('success', 'Pembayaran berhasil diverifikasi');
}

public function rejectPayment(Booking $booking)
{
    $booking->update(['status' => 'rejected']);
    return back()->with('success', 'Pembayaran telah ditolak');
}

public function earnings(Request $request)
{
    // Hitung total penghasilan
    $totalEarnings = Booking::where('status', 'confirmed')->sum('total_harga');
    
    // Hitung penghasilan bulan ini
    $monthlyEarnings = Booking::where('status', 'confirmed')
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->sum('total_harga');
    
    // Hitung penghasilan minggu ini
    $weeklyEarnings = Booking::where('status', 'confirmed')
        ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
        ->sum('total_harga');
    
    // Hitung transaksi hari ini
    $todayBookingsCount = Booking::where('status', 'confirmed')
        ->whereDate('created_at', today())
        ->count();
    
    // Filter tahun dan studio
    $selectedYear = $request->input('year', date('Y'));
    $selectedStudio = $request->input('studio', null);
    
    // Dapatkan tahun yang tersedia
    $availableYears = Booking::selectRaw('YEAR(created_at) as year')
        ->groupBy('year')
        ->orderBy('year', 'desc')
        ->pluck('year');
    
    // Data untuk grafik bulanan
    $monthlyData = [];
    $monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    
    for ($i = 1; $i <= 12; $i++) {
        $query = Booking::where('status', 'confirmed')
            ->whereMonth('created_at', $i)
            ->whereYear('created_at', $selectedYear);
            
        if ($selectedStudio) {
            $query->where('studio_id', $selectedStudio);
        }
        
        $monthlyData[] = $query->sum('total_harga');
    }
    
    // Daftar studio untuk filter
    $studios = Studio::all();
    
    $newOrdersCount = Booking::whereIn('status', ['pending', 'waiting_verification'])->count();
    
    return view('dashboard.earnings', [
        'totalEarnings' => $totalEarnings,
        'monthlyEarnings' => $monthlyEarnings,
        'weeklyEarnings' => $weeklyEarnings,
        'todayBookingsCount' => $todayBookingsCount,
        'monthlyData' => $monthlyData,
        'monthlyLabels' => $monthlyLabels,
        'availableYears' => $availableYears,
        'selectedYear' => $selectedYear,
        'studios' => $studios,
        'selectedStudio' => $selectedStudio,
        'newOrdersCount' => $newOrdersCount,
    ]);
}
}
