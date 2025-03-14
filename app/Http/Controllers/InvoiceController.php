<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Contracts\InvoiceServiceContract;

class InvoiceController extends Controller
{
    public function __invoke(string $vendor_order_id, InvoiceServiceContract $invoiceService)
    {
        $order = Order::where('vendor_order_id', $vendor_order_id)->firstOrFail();

        if (auth()->user()->cannot('view', $order)) {
            notify()->warning('You do not have permission to view this invoice.');

            return redirect()->route('home');
        }

        return $invoiceService->generate($order)->stream();
    }
}
