<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use App\Models\User; // Pastikan ini yang digunakan

class AuthController extends Controller
{
     /**
     * Menampilkan form login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);
    
        // Deteksi apakah input email atau username
        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        $credentials = [
            $fieldType => $request->login,
            'password' => $request->password
        ];
    
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Regenerasi session ID untuk keamanan
            $request->session()->regenerate();
            
            // Simpan user_id ke session
            $request->session()->put('user_id', Auth::id());
            
            // Tambahkan data user lainnya jika diperlukan
            $request->session()->put('user_name', Auth::user()->name);
            
            return redirect()->route('index')->with('success', 'Login berhasil!');
        }
    
        return back()->withErrors([
            'login' => 'Email/username atau password salah',
        ])->withInput($request->only('login', 'remember'));
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        
        $request->session()->regenerateToken();
        
        return redirect()->route('index');
    }

    /**
     * Menampilkan form registrasi
     */
    // Tambahkan method ini ke AuthController Anda
public function showRegistrationForm()
{
    return view('auth.register');
}

public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:20|unique:users', // Tambah validasi
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    User::create([
        'name' => $request->name,
        'username' => $request->username, // Tambahkan ini
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Redirect ke login setelah registrasi
    return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
}


}