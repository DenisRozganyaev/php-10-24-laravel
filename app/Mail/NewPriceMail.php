<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewPriceMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly Product $product, public array $data = [])
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: 'wishlist@shop.com',
            cc: ['public@admin.com'],
            bcc: ['private@admin.com'],
            subject: 'New Price Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.new-price-mail',
            with: [
                'url' => url(route('products.show', $this->product)),
                'imageUrl' => $this->product->thumbnailUrl,
                'price' => $this->product->finalPrice,
                ...$this->data,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
