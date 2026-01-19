<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

class UsersControllerWeb extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role'     => 'required|in:admin,mahasiswa,dosen',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $photo = null;
        $photoThumb = null;

        // ===== FOTO (SAMA DENGAN MOBILE) =====
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            $filename = time() . '.' . $file->getClientOriginalExtension();
            $fileNameThumb = 'thumb_' . time() . '.' . $file->getClientOriginalExtension();

            // Simpan foto utama
            $filePath = $file->storeAs('photos', $filename, 'public');

            // Folder thumbnail
            $thumbnailPath = public_path('storage/photos/thumbnail');
            if (!File::exists($thumbnailPath)) {
                File::makeDirectory($thumbnailPath, 0755, true);
            }

            // Buat thumbnail
            $image = Image::read($file);
            $image->scaleDown(width: 200);
            $image->save($thumbnailPath . '/' . $fileNameThumb);

            $photo = Storage::url($filePath);
            $photoThumb = Storage::url('photos/thumbnail/' . $fileNameThumb);
        }

        User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role'        => $request->role,
            'photo'       => $photo,
            'photo_thumb' => $photoThumb,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'role'     => 'required|in:admin,mahasiswa,dosen',
            'password' => 'nullable|min:8',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        // Password
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // ===== FOTO (SAMA DENGAN MOBILE) =====
        if ($request->hasFile('photo')) {

            // Hapus foto lama
            if ($user->photo) {
                File::delete(public_path($user->photo));
            }
            if ($user->photo_thumb) {
                File::delete(public_path($user->photo_thumb));
            }

            $file = $request->file('photo');

            $filename = time() . '.' . $file->getClientOriginalExtension();
            $fileNameThumb = 'thumb_' . time() . '.' . $file->getClientOriginalExtension();

            $filePath = $file->storeAs('photos', $filename, 'public');

            $thumbnailPath = public_path('storage/photos/thumbnail');
            if (!File::exists($thumbnailPath)) {
                File::makeDirectory($thumbnailPath, 0755, true);
            }

            $image = Image::read($file);
            $image->scaleDown(width: 200);
            $image->save($thumbnailPath . '/' . $fileNameThumb);

            $data['photo'] = Storage::url($filePath);
            $data['photo_thumb'] = Storage::url('photos/thumbnail/' . $fileNameThumb);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Hapus foto
        if ($user->photo) {
            File::delete(public_path($user->photo));
        }
        if ($user->photo_thumb) {
            File::delete(public_path($user->photo_thumb));
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus');
    }
}
