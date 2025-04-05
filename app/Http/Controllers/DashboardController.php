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

    public function settings()
    {
        // Fetch portfolio items ordered by their display order
        $portfolioItems = Portfolio::orderBy('order')->get();
        
        return view('dashboard.settings', compact('portfolioItems'));
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
}
