<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\WishListEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'password',
        'phone',
        'birthday',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function wishes(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'wish_list',
            'user_id',
            'product_id'
        )->withPivot(['price', 'in_stock']);
    }

    public function addToWishList(int $productId, WishListEnum $type = WishListEnum::Price): void
    {
        $wished = $this->wishes()->find($productId);

        $data = [
            $type->value => true
        ];

        if ($wished) {
             $this->wishes()->updateExistingPivot($wished, $data);
        } else {
            $this->wishes()->attach($productId, $data);
        }
    }

    public function removeFromWishList(int $productId, WishListEnum $type = WishListEnum::Price): void
    {
        $this->wishes()->updateExistingPivot($productId, [$type->value => false]);

        $wished = $this->wishes()->find($productId);

        if (! $wished->pivot->price && ! $wished->pivot->in_stock) {
            $this->wishes()->detach($productId);
        }
    }

    public function isWished(int $productId, WishListEnum $type = WishListEnum::Price): bool
    {
        return $this->wishes()
            ->where('product_id', $productId)
            ->wherePivot($type->value, true)
            ->exists();
    }
}
