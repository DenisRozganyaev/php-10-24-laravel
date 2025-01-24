<?php

namespace App\Services\Contracts;

use Illuminate\Http\UploadedFile;

interface FileServiceContract
{
    public function upload(UploadedFile $file, string $path): string;
}
