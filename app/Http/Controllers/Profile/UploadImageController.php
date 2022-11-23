<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\UserProfileImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class UploadImageController extends Controller
{
    public function __invoke (Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,png,jpeg,heif,heic'
        ]);

        $file = $request->file('file'); // /tmp/php7S8v..

        $path = $file->hashName();

        $image = Image::make($file)->fit(1000, 1000);

        $disk = (app()->environment() === 'production')
            ? 's3'
            : 'local';

        $filesystem = Storage::disk($disk);
        $filesystem->put($path, $image->stream(), 'public');

        // our image will live here
        $url = $filesystem->url($path);

        // get the image where the 'user_id' matches the current authenticated user
        $userProfileImage = UserProfileImage::where('user_id', auth()->user()->id)->first();

        if (!$userProfileImage) // if the user profile image doesn't exist create one
        {
            $userProfileImage = UserProfileImage::create([
                'user_id' => auth()->user()->id,
                'url' => $url
            ]);
        }
        else
        {
            $userProfileImage->url = $url;
            $userProfileImage->save();
        }

        return [
            'success' => true,
            'user_profile_image' => $userProfileImage,
        ];
    }
}
