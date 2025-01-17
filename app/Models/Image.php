<?php

namespace App\Models;

use App\Observers\ImageObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[ObservedBy([ImageObserver::class])]
class Image extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    public function url(): Attribute
    {
        return Attribute::get(function () {
            return Storage::url($this->attributes['path']);
        });
    }

    public function setPathAttribute(array $pathData): void
    {
        /**
         * @var \Illuminate\Http\UploadedFile $file
         */
        $file = $pathData['image'];
        $fileName = Str::slug(microtime());
        $filePath = $pathData['path'] . $fileName . $file->getClientOriginalName();

        Storage::put($filePath, File::get($file));
        Storage::setVisibility($filePath, 'public');

        $this->attributes['path'] = $filePath;
    }
}
