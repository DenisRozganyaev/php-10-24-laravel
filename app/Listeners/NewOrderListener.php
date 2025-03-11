<?php

namespace App\Listeners;

use App\Enums\RoleEnum;
use App\Events\OrderCreatedEvent;
use App\Models\User;
use App\Notifications\Orders\Created\AdminNotification;
use App\Notifications\Orders\Created\UserNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class NewOrderListener implements ShouldQueue
{
    public function viaQueue(): string
    {
        return 'default';
    }

    public function handle(OrderCreatedEvent $event): void
    {
        logs()->info('[NewOrderListener] handle!');

        Notification::send(
            User::role(RoleEnum::ADMIN->value)->get(),
            app(
                AdminNotification::class,
                ['order' => $event->order]
            )
        );

        $event->order->notify(app(
            UserNotification::class,
            ['order' => $event->order]
        ));
    }
}
