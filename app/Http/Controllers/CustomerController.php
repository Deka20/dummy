<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
   // Controller
   public function index()
   {
       $users = User::all(); // Mengambil semua data user
       // atau jika ingin dengan pagination:
       // $users = User::paginate(20); 
       
       return view('dashboard.customers.index', compact('users'));
   }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.customers.edit', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Delete avatar file if exists
        if ($user->avatar) {
            Storage::delete('public/avatars/'.$user->avatar);
        }
        
        $user->delete();
        return redirect()->route('dashboard.customers')->with('success', 'Customer deleted successfully!');
    }

    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,'.$id,
        'email' => 'required|email|max:255|unique:users,email,'.$id,
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'remove_avatar' => 'nullable|boolean',
    ]);

    $user = User::findOrFail($id);
    
    // Hapus avatar jika diperlukan
    if ($request->remove_avatar) {
        if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
            Storage::delete('public/avatars/' . $user->avatar);
        }
        $user->avatar = null;
    }

    // Update data user
    $user->name = $request->name;
    $user->username = $request->username;
    $user->email = $request->email;

    if ($request->hasFile('avatar')) {
        // Proses update avatar
        $this->updateAvatar($request, $user);
    }

    $user->save();

    return redirect()->route('dashboard.customers')
        ->with('success', 'Customer updated successfully!');
}

    protected function updateAvatar($request, $user)
{
    // Hapus avatar lama jika ada
    if ($user->avatar) {
        Storage::delete('public/avatars/' . $user->avatar);
    }

    // Upload avatar baru
    if ($request->hasFile('avatar')) {
        $file = $request->file('avatar');
        $filename = time() . '_' . $file->getClientOriginalName();
        
        // Simpan file ke storage
        $path = $file->storeAs('public/avatars', $filename, 'public');

        if (!$path) {
            return back()->with('error', 'Gagal menyimpan avatar');
        }

        $user->avatar = $filename;
        $user->save();
    }
}
}