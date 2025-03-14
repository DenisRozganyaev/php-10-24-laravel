<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     * index
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([RoleEnum::ADMIN->value, RoleEnum::MODERATOR->value]);
    }

    /**
     * Determine whether the user can view the model.
     * show
     */
    public function view(User $user, Order $order): bool
    {
        //        return $user->hasAnyRole([RoleEnum::ADMIN->value, RoleEnum::MODERATOR->value]) ||
        return $order->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     * store
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole([RoleEnum::ADMIN->value, RoleEnum::MODERATOR->value]);
    }

    /**
     * Determine whether the user can update the model.
     * update
     */
    public function update(User $user, Order $order): bool
    {
        return $user->hasAnyRole([RoleEnum::ADMIN->value, RoleEnum::MODERATOR->value]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order): bool
    {
        return $user->hasAnyRole([RoleEnum::ADMIN->value]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Order $order): bool
    {
        return $user->hasAnyRole([RoleEnum::ADMIN->value]);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Order $order): bool
    {
        return $user->hasAnyRole([RoleEnum::ADMIN->value]);
    }
}
