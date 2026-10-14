<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public const KELAS = ['X', 'XI', 'XII', 'Lulus / Gap Year'];

    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user'      => $request->user(),
            'kelasList' => self::KELAS,
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'asal_sekolah' => ['nullable', 'string', 'max:255'],
            'kelas'        => ['nullable', Rule::in(self::KELAS)],
            'photo'        => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'name.required'  => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email sudah dipakai akun lain.',
            'kelas.in'       => 'Pilihan kelas tidak valid.',
            'photo.image'    => 'File harus berupa gambar.',
            'photo.mimes'    => 'Format foto harus PNG atau JPG.',
            'photo.max'      => 'Ukuran foto maksimal 2 MB.',
        ]);

        try {
            $user->name         = $data['name'];
            $user->email        = $data['email'];
            $user->asal_sekolah = $data['asal_sekolah'] ?? null;
            $user->kelas        = $data['kelas'] ?? null;

            // Hapus foto lama kalau diminta
            if ($request->boolean('remove_photo') && $user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
                $user->profile_photo_path = null;
            }

            // Upload foto baru
            if ($request->hasFile('photo')) {
                if ($user->profile_photo_path) {
                    Storage::disk('public')->delete($user->profile_photo_path);
                }
                $user->profile_photo_path = $request->file('photo')->store('profile-photos', 'public');
            }

            $user->save();
        } catch (\Throwable $e) {
            Log::error('Update profil gagal: ' . $e->getMessage());

            return back()
                ->withErrors(['umum' => 'Gagal menyimpan: ' . $e->getMessage()])
                ->withInput();
        }

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}