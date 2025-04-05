<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        
        if (!$user instanceof User) {
            abort(403, 'Unauthorized action.');
        }

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || !$user instanceof User) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'remove_avatar' => 'nullable|boolean',
        ]);

        DB::beginTransaction();

        try {
            // Update user data
            $user->fill($validatedData);

            // Handle avatar removal
            if ($request->boolean('remove_avatar')) {
                $this->removeCurrentAvatar($user);
            }

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $this->uploadNewAvatar($request->file('avatar'), $user);
            }

            if (!$user->save()) {
                throw new \RuntimeException('Failed to save user data');
            }

            DB::commit();

            return redirect()->route('profile.edit')
                         ->with('success', 'Profile updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating profile: '.$e->getMessage());
        }
    }

    protected function removeCurrentAvatar(User $user)
    {
        if ($user->avatar) {
            $avatarPath = 'public/avatars/'.$user->avatar;
            if (Storage::exists($avatarPath)) {
                Storage::delete($avatarPath);
            }
            $user->avatar = null;
        }
    }

    protected function uploadNewAvatar($file, User $user)
    {
        $this->removeCurrentAvatar($user);

        // Generate safe filename
        $filename = Str::random(40).'.'.$file->getClientOriginalExtension();
        
        // Store file to public/avatars directory
        $path = $file->storeAs(
            'public/avatars', // Hanya gunakan 'public/avatars' tanpa 'storage/'
            $filename
        );

        if (!$path) {
            throw new \RuntimeException('Failed to store avatar file');
        }

        // Update only the avatar field
        $user->avatar = $filename;
    }
}