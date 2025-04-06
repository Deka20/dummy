<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Studio;
use App\Models\Booking;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    // BookingController.php
public function show($id)
{
    $booking = Booking::with(['studio', 'user'])->findOrFail($id);
    
    // Verifikasi kepemilikan booking
    if ($booking->user_id != Auth::id()) {
        abort(403, 'Unauthorized');
    }

    return view('show', ['booking' => $booking]); // atau compact('booking')
}

public function create(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'studio_id' => 'required|exists:studios,id',
        'jumlah_pelanggan' => 'required|integer|min:1|max:10',
        'tanggal_reservasi' => 'required|date|after_or_equal:today',
        'waktu_reservasi' => 'required',
        'durasi_jam' => 'required|integer|min:1|max:3',
        'biaya_per_pelanggan' => 'required|integer|min:0', // Tambahkan validasi biaya per pelanggan
        'total_harga' => 'required|numeric|min:0'
    ]);

    // Dapatkan user_id dari session (fallback ke auth() jika session kosong)
    $userId = Session::get('user_id') ?? Auth::id();

    // Pastikan user_id tersedia
    if (!$userId) {
        return redirect()->back()
               ->with('error', 'Anda harus login terlebih dahulu')
               ->withInput();
    }

    // Gunakan total harga yang sudah dihitung di frontend
    $totalHarga = $validated['total_harga'];
    $studio = Studio::findOrFail($request->studio_id);
    $bookingId = $this->generateBookingId($studio->nama, $request->tanggal_reservasi);

    // Simpan data ke database
    $booking = Booking::create([
        'user_id' => $userId,
        'booking_id' => $bookingId,
        'studio_id' => $validated['studio_id'],
        'jumlah_pelanggan' => $validated['jumlah_pelanggan'],
        'tanggal_reservasi' => $validated['tanggal_reservasi'],
        'waktu_reservasi' => $validated['waktu_reservasi'],
        'durasi_jam' => $validated['durasi_jam'],
        'total_harga' => $totalHarga,
        'status' => 'pending'
    ]);

    return response()->json([
        'success' => true,
        'booking_id' => $booking->booking_id,
    ]);
    
}

private function generateBookingId($studioName, $tanggal)
{
    $studioCode = collect(explode(' ', $studioName))->map(function ($word) {
        return strtoupper(substr($word, 0, 1));
    })->implode('');

    $dateCode = Carbon::parse($tanggal)->format('Ymd');
    $random = strtoupper(Str::random(5));

    return "BK-$dateCode-$studioCode-$random";
}



public function store(Request $request)
{
    $validated = $request->validate([
        'studio_id' => 'required|exists:studios,id',
        'jumlah_pelanggan' => 'required|integer|min:1',
        'tanggal_reservasi' => 'required|date',
        'waktu_reservasi' => 'required',
        'durasi_jam' => 'required|integer|min:1',
    ]);

    $userId = Session::get('user_id') ?? Auth::id();

    // Contoh hitung total harga
    $studio = Studio::findOrFail($validated['studio_id']);
    $totalHarga = $studio->harga_per_jam * $validated['durasi_jam'];

    $booking = Booking::create([
        'user_id' => $userId,
        'studio_id' => $validated['studio_id'],
        'jumlah_pelanggan' => $validated['jumlah_pelanggan'],
        'tanggal_reservasi' => $validated['tanggal_reservasi'],
        'waktu_reservasi' => $validated['waktu_reservasi'],
        'durasi_jam' => $validated['durasi_jam'],
        'total_harga' => $totalHarga,
        'status' => 'pending'
    ]);

    return redirect()->route('bookings.index')
           ->with('success', 'Reservasi berhasil dibuat! Total harga: Rp '.number_format($totalHarga, 0, ',', '.'))
           ->with('booking_id', $booking->id);
}

    public function updateStatus(Booking $booking, Request $request)
{
    $validated = $request->validate([
        'status' => 'required|in:pending,confirmed,cancelled,completed'
    ]);

    $booking->update(['status' => $validated['status']]);

    return response()->json(['message' => 'Status updated successfully']);
}

// PurchaseController.php
public function purchaseHistory(Request $request)
{
    // Ambil user yang sedang login
    $user = Auth::user();
    
    // Query untuk mendapatkan riwayat pembelian
    $bookings = Booking::with(['studio', 'user']) // Eager load relasi studio dan user
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
    return view('purchase_history', compact('bookings'));
}

// BookingController.php
public function requestCancel($id)
{
    try {
        $booking = Booking::findOrFail($id);
        
        // Validasi kepemilikan
        if ($booking->user_id != Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }
        
        // Validasi status yang bisa di-cancel
        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya booking dengan status pending atau confirmed yang bisa dibatalkan'
            ], 400);
        }
        
        // Ubah status menjadi request cancel
        $booking->status = 'request_cancel';
        $booking->save();
        
        // Tambahkan log/notifikasi jika perlu
        Log::info("User requested cancellation for booking #{$booking->id}");
        
        return response()->json([
            'success' => true,
            'message' => 'Permintaan pembatalan telah dikirim',
            'status' => $booking->status
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}

public function submitReview(Request $request, Booking $booking)
{
    $validated = $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'required|string|min:10|max:500',
    ]);

    // Pastikan booking milik user yang login dan status completed
    if ($booking->user_id != Auth::id() || $booking->status != 'completed') {
        abort(403, 'Unauthorized action');
    }

    $booking->update([
        'rating' => $validated['rating'],
        'review' => $validated['review'],
        'reviewed_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Ulasan berhasil disimpan!');
}

public function update(Request $request, Booking $booking)
{
    if (Auth::id() !== $booking->user_id) {
        abort(403);
    }

    $data = $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'required|string|max:1000',
    ]);

    $booking->update([
        'rating' => $data['rating'],
        'review' => $data['review'],
        'reviewed_at' => now(),
    ]);

    // ✅ Redirect ke halaman dengan pesan sukses
    return redirect()->route('index')->with('success', 'Review updated.');
}


public function destroy(Booking $booking)
{
    if (Auth::id() !== $booking->user_id) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $booking->update([
        'review' => null,
        'rating' => null,
        'reviewed_at' => null,
    ]);

    return redirect()->route('index')->with('success', 'Review deleted.');
}

public function updateBooking(Request $request, Booking $booking)
{
    // Validasi kepemilikan booking
    if ($booking->user_id != Auth::id()) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized action'
        ], 403);
    }

    // Validasi input
    $validated = $request->validate([
        'date' => 'required|date|after_or_equal:today',
        'time' => 'required',
    ]);

    try {
        // Update data booking
        $booking->update([
            'tanggal_reservasi' => $validated['date'],
            'waktu_reservasi' => $validated['time'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reservasi berhasil diperbarui',
            'booking' => $booking
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}
}