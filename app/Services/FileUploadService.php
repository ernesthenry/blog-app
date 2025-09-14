<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FileUploadService
{
    public function uploadPostImage(UploadedFile $file, $folder = 'posts')
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs($folder, $filename, 'public');
        
        // Resize image if needed
        $fullPath = storage_path('app/public/' . $path);
        $image = Image::make($fullPath);
        
        if ($image->width() > 800) {
            $image->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
        }
        
        return $path;
    }

    public function deleteFile($path)
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return false;
    }
}