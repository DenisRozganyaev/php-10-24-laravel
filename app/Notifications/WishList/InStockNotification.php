<?php

namespace App\Notifications\WishList;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InStockNotification extends Notification
{
    use Queueable;

    public function __construct(public readonly Product $product, public array $data = [])
    {
        $this->onQueue('wishlist-notification');
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('In Stock Notification')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }
}
