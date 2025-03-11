<?php

namespace App\Services;

use App\Models\Order;
use App\Services\Contracts\InvoiceServiceContract;
use Illuminate\Database\Eloquent\Collection;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Invoice;

class InvoiceService implements InvoiceServiceContract
{
    public function generate(Order $order): Invoice
    {
        $order->loadMissing(['transaction', 'products']);

        $customer = new Buyer([
            'name' => "$order->name $order->lastname",
            'phone' => $order->phone,
            'custom_fields' => [
                'email' => $order->email,
                'city' => $order->city,
                'address' => $order->address,
            ],
        ]);

        $invoice = Invoice::make()
            ->buyer($customer)
            ->status($order->status->value)
            ->filename($order->vendor_order_id)
            ->taxRate(config('cart.tax'))
            ->addItems($this->invoiceItems($order->products))
            ->logo(public_path('vendor/invoices/sample-logo.png'))
            ->save();

        return $invoice;
    }

    protected function invoiceItems(Collection $products): array
    {
        $items = [];

        foreach ($products as $product) {
            $items[] = InvoiceItem::make($product->pivot->name)
                ->quantity($product->pivot->quantity)
                ->pricePerUnit($product->pivot->single_price)
                ->units('шт');
        }

        return $items;
    }
}
