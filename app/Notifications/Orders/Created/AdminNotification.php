<?php

namespace App\Notifications\Orders\Created;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Order $order)
    {
        //
    }

    public function viaQueues(): array
    {
        return [
            'mail' => 'admin-notification',
        ];
    }

    public function via(User $user): array
    {
        return ['mail'];
    }

    public function toMail(User $user): MailMessage
    {
        return (new MailMessage)
            ->subject('New Order #'.$this->order->id)
            ->line("Hey $user->name,")
            ->line('There is a new order here')
            ->action(
                'Open the order invoice',
                url(route('order.invoice', $this->order->vendor_order_id))
            )
            ->line('Or you can see that in mail attachments');
    }
}
