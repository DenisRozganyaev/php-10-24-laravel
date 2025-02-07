<?php

namespace App\Http\Controllers\Ajax\Payments;

use App\Enums\PaymentSystemEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Repositories\OrderRepository;
use App\Services\PaypalService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PaypalController extends Controller
{
    public function __construct(
        protected PaypalService $paypalService,
        protected OrderRepository $orderRepository
    ) {}

    public function create(CreateOrderRequest $request)
    {
        $data = $request->validated();
        try {
            DB::beginTransaction();

            $paypalOrderId = $this->paypalService->create();

            if (! $paypalOrderId) {
                throw new \Exception('Could not create paypal order. Payment was not completed');
            }

            $data['vendor_order_id'] = $paypalOrderId;

            $order = $this->orderRepository->create($data);

            DB::commit();

            return response()->json($order);
        } catch (Throwable $exception) {
            DB::rollBack();

            logs()->error('[PaypalController::create] ' . $exception->getMessage(), [
                'exception' => $exception,
                'data' => $data,
            ]);

            return response()->json([
                'error' => $exception->getMessage(),
            ], 422);
        }
    }

    public function capture(string $vendorOrderId)
    {
        try {
            DB::beginTransaction();

            $paymentStatus = $this->paypalService->capture($vendorOrderId);

            $this->orderRepository->setTransaction(
                $vendorOrderId,
                PaymentSystemEnum::Paypal,
                $paymentStatus
            );

            Cart::instance('cart')->destroy();

            DB::commit();

            return response()->json([
                'orderId' => $vendorOrderId
            ]);
        } catch (Throwable $exception) {
            DB::rollBack();

            logs()->error('[PaypalController::capture] ' . $exception->getMessage(), [
                'exception' => $exception,
                'vendor_order_id' => $vendorOrderId,
            ]);

            return response()->json([
                'error' => $exception->getMessage(),
            ], 422);
        }
    }
}
