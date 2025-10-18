<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Media\StorePhotoProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoProfileController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Media\StorePhotoProfileRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePhotoProfileRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $user = $request->user();

            if ($user->photo) {
                $oldPath = str_replace('storage/', '', $user->photo);

                Storage::disk('public')->delete($oldPath);
            }

            $photoProfile = $data['photo'];

            $photoName = $photoProfile->hashName();

            Storage::disk('public')->putFileAs('profile', $photoProfile, $photoName);

            $user->update([
                'photo' => "storage/profile/{$photoName}"
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil diubah',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Foto profil gagal diubah',
        ], 400);
    }

    /**
     * Delete the user's photo profile.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $user = $request->user();

        if ($user->photo) {
            $oldPath = str_replace('storage/', '', $user->photo);

            Storage::disk('public')->delete($oldPath);

            $user->update([
                'photo' => null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil dihapus',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Foto profil gagal dihapus',
        ], 400);
    }
}
