<?php

namespace App\Notifications\WishList;

use App\Mail\NewPriceMail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Notifications\Notification;

class NewPriceNotification extends Notification
{
    use Queueable;

    public function __construct(public readonly Product $product, public array $data = [])
    {
        $this->onQueue('wishlist-notification');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $user): Mailable
    {
        return app(NewPriceMail::class, [
            'product' => $this->product,
            'data' => $this->data,
        ])->to($user->email);
    }
}
