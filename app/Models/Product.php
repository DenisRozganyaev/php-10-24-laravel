<?php

namespace App\Models;

use App\Observers\ProductObserver;
use App\Services\Contracts\FileServiceContract;
use Gloudemans\Shoppingcart\CanBeBought;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

#[ObservedBy([ProductObserver::class])]
class Product extends Model implements Buyable
{
    use HasFactory, CanBeBought;

    protected $guarded = [];

    public function getRouteKeyName(): string
    {
        return request()->wantsJson() ? 'id' : 'slug';
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    // $product->thumbnailUrl
    public function thumbnailUrl(): Attribute
    {
        return Attribute::get(function () {
            return Storage::url($this->attributes['thumbnail']);
        });
    }

    public function setThumbnailAttribute(UploadedFile $file): void
    {
        if (!empty($this->attributes['thumbnail'])) {
            Storage::delete($this->attributes['thumbnail']);
        }

        $filePath = 'products/' . $this->attributes['slug'];

        $this->attributes['thumbnail'] = app(FileServiceContract::class)
            ->upload($file, $filePath);
    }

    public function finalPrice(): Attribute
    {
        return Attribute::get(fn () => round($this->attributes['price'] - ($this->attributes['price'] * $this->attributes['discount'] / 100), 2));
    }

    public function imagesFolderPath(): string
    {
        return "products/$this->slug/";
    }

    public function getBuyablePrice($options = null)
    {
        return $this->finalPrice;
    }
}
