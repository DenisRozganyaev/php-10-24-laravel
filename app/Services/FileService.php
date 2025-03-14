<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService implements Contracts\FileServiceContract
{
    public function upload(UploadedFile $file, string $path): string
    {
        $fileName = Str::slug(microtime());
        $filePath = $path."/{$fileName}".$file->getClientOriginalName();

        Storage::put($filePath, File::get($file));
        Storage::setVisibility($filePath, 'public');

        return $filePath;
    }
}
