<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait Upload
{
    public function UploadFile(UploadedFile $file, $folder = "uploadedPhotos", $disk = 'images', $filename = null)
    {
        $FileName = !is_null($filename) ? $filename : time() . '-' . $file->getClientOriginalName();
        return $file->storeAs(
            $folder,
            $FileName,
            $disk
        );
    }

    public function deleteFile($path, $disk = 'images')
    {
        Storage::disk($disk)->delete($path);
    }
}
