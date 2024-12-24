<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    // get parent category data
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // get children category data
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
