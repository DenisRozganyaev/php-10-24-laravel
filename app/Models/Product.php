<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    // $product->thumbnailUrl
    public function thumbnailUrl(): Attribute
    {
        return Attribute::get(function () {
            return Storage::url($this->attributes['thumbnail']);
        });
    }

    public function thumbnail(): Attribute
    {
        return Attribute::set(function (UploadedFile $file) {
            $fileName = Str::slug(microtime());
            $filePath = 'products/' . $this->attributes['slug'] . "/$fileName" . $file->getClientOriginalName();

            Storage::put($filePath, File::get($file));
            Storage::setVisibility($filePath, 'public');

            return $filePath;
        });
    }

    public function imagesFolderPath(): string
    {
        return "products/$this->slug/";
    }
}
