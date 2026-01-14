<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UsersControllerMobile extends Controller
{
    public function updateUserPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|file|mimes:jpeg,jpg,png|max:5120',
        ], [
            'photo.required' => 'Foto wajib diisi.',
            'photo.file' => 'Foto yang diunggah berupa gambar.',
            'photo.mimes' => 'Foto harus berformat jpeg, jpg, atau png.',
            'photo.max' => 'Ukuran foto maksimal 5MB.',
        ]);

        $user = $request->user();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            $filename = time() . '.' . $file->getClientOriginalExtension();
            $fileNameThumb = 'thumb_' . time() . '.' . $file->getClientOriginalExtension();

            // Hapus foto lama
            if ($user->photo) {
                $oldPhotoPath = public_path($user->photo);
                if (File::exists($oldPhotoPath)) {
                    File::delete($oldPhotoPath);
                }
            }

            if ($user->photo_thumb) {
                $oldThumbPath = public_path($user->photo_thumb);
                if (File::exists($oldThumbPath)) {
                    File::delete($oldThumbPath);
                }
            }

            // Simpan foto utama
            $filePath = $file->storeAs('photos', $filename, 'public');

            // Folder thumbnail
            $destinationPathThumbnail = public_path('storage/photos/thumbnail');
            if (!File::exists($destinationPathThumbnail)) {
                File::makeDirectory($destinationPathThumbnail, 0755, true);
            }

            // Buat kompress
            $image = Image::read($file);
            $image->scaleDown(width: 200);
            $image->save($destinationPathThumbnail . '/' . $fileNameThumb);

            // Simpan ke database
            $user->photo = Storage::url($filePath);
            $user->photo_thumb = Storage::url('photos/thumbnail/' . $fileNameThumb);
            $user->save();

            return response()->json([
                'message' => 'Photo berhasil diupdate',
                'foto' => $user->photo,
                'foto_thumb' => $user->photo_thumb,
            ], 200);
        }

        return response()->json([
            'message' => 'Tidak ada foto yang diunggah.'
        ], 400);
    }

    public function updateUser(Request $request)
    {
        $request->validate([
            'name'   => 'sometimes|string|max:255',
            'email'  => 'sometimes|string|email|max:255|unique:users,email,' . $request->user()->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = $request->user();

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            if ($request->password !== $request->password_confirmation) {
                return response()->json(['message' => 'Password and confirm password do not match'], 400);
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'message' => 'User updated successfully!',
            'data'    => $user
        ], 200);
    }
}
