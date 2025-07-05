<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil pengguna.
     */
    public function index()
    {
        return view('dashboard.profile.index', [
            'title' => 'My Profile',
            'active' => 'profile',
            'user' => Auth::user()
        ]);
    }

    /**
     * Mengupdate foto profil pengguna.
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        $model = $user->role == 'mahasiswa' ? $user->mahasiswa : $user->dosenpa;

        if ($model) {
            // Hapus foto lama jika ada
            if ($model->foto) {
                Storage::disk('public')->delete($model->foto);
            }
            // Simpan foto baru
            $path = $request->file('foto')->store('foto-' . $user->role, 'public');
            $model->update(['foto' => $path]);
        }

        return back()->with('success', 'Foto profil berhasil diupdate!');
    }

    /**
     * Mengupdate password pengguna.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }
}
