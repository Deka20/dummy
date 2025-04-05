<?php

namespace App\Http\Controllers;

use App\Models\Studio;
use App\Models\Booking;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    // Tidak perlu properti $fillable di controller, karena sudah ada di Model Studio

    public function index()
    {
        // Menggunakan paginate untuk menampilkan data dalam halaman (10 studio per halaman)
        $studios = Studio::paginate(10); 
        // Mengembalikan view dengan data studios
        return view('dashboard.studios', compact('studios'));
    }

    public function edit($id)
    {
        // Mengambil studio berdasarkan ID yang ada di database
        $studio = Studio::findOrFail($id);
        return view('dashboard.edit', compact('studio'));
    }

    public function update(Request $request, Studio $studio)
{
    // Validate the incoming data
    $request->validate([
        'nama' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'kapasitas' => 'required|integer',
        'harga_per_jam' => 'required|numeric',
        'cover_studio' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ]);

    // Update the studio
    $studio->nama = $request->nama;
    $studio->deskripsi = $request->deskripsi;
    $studio->kapasitas = $request->kapasitas;
    $studio->harga_per_jam = $request->harga_per_jam;
    $studio->cover_studio = $request->cover_studio;
    $studio->save();

    // Redirect with success message
    return redirect()->route('dashboard.studios')->with('success', 'Studio updated successfully!');
}


public function destroy(Studio $studio)
{
    
    $studio->delete();

    return redirect()->route('dashboard.studios')->with('success', 'Studio berhasil dihapus.');
}




    public function create()
    {
        return view('dashboard.create'); // Form untuk create studio
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kapasitas' => 'required|integer|min:1',
            'harga_per_jam' => 'required|numeric|min:0',
            'cover_studio' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        
        // Buat array data baru (jangan gunakan $validated)
        $studioData = [
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'kapasitas' => $request->kapasitas,
            'harga_per_jam' => $request->harga_per_jam,
        ];
        
        // Upload dan simpan path file
        if ($request->hasFile('cover_studio')) {
            $file = $request->file('cover_studio');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('studio_covers', $filename, 'public');
            
            // Tambahkan path ke array data studio
            $studioData['cover_studio'] = $path;
        } else {
            // Debug untuk melihat apakah file ada dalam request
            return back()->with('error', 'No file uploaded!');
        }
        
        // Debug - periksa data sebelum simpan
        // dd($studioData);
        
        // Simpan ke database
        Studio::create($studioData);
        
        return redirect()->route('dashboard.studios')
             ->with('success', 'Studio created successfully!');
    }
    
    

// In your controller
public function dashboard()
{
    $recentBookings = Booking::with('user')
        ->orderBy('tanggal_reservasi', 'desc')
        ->take(5)
        ->get();
    
    return view('dashboard', compact('recentBookings'));
}
    
public $timestamps = true; // Pastikan timestamps aktif


}

