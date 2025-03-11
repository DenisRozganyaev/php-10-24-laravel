<?php

namespace App\Broadcasting;

use App\Enums\RoleEnum;
use App\Models\User;

class AdminChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user): array|bool
    {
        logs()->info('[AdminChannel] Email='.$user->email.' => '.($user->hasRole(RoleEnum::ADMIN->value) ? 'true' : 'false'));

        return $user->hasRole(RoleEnum::ADMIN->value);
    }
}
