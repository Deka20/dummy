<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function profile()
    {
        return view('profile.edit');
    }

    public function security()
    {
        return view('settings.security');
    }

    public function updatePassword(Request $request)
{
    // Validasi dengan pengecekan password saat ini
    $request->validate([
        'current_password' => [
            'required',
            function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('Password saat ini salah');
                }
            }
        ],
        'password' => [
            'required',
            'confirmed',
            Password::min(8)
                ->letters()
                ->numbers()
        ]
    ]);

    try {
        // Gunakan query builder langsung untuk menghindari masalah model
        DB::table('users')
            ->where('id', Auth::id())
            ->update([
                'password' => Hash::make($request->password),
                'updated_at' => now()
            ]);

        // Refresh user data in session
        $updatedUser = User::find(Auth::id());
        Auth::setUser($updatedUser);

        return back()->with('success', 'Password berhasil diubah!');

    } catch (\Exception $e) {
        Log::error('Password update failed: '.$e->getMessage());
        return back()->with('error', 'Gagal mengubah password');
    }
}

public function preferences() {
    return view('settings.preferences');
}
}