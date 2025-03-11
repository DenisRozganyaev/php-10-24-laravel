<?php

namespace App\Http\Controllers\Ajax\Payments;

use App\Enums\PaymentSystemEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Repositories\OrderRepository;
use App\Services\Contracts\StripeServiceContract;
use App\Services\PaypalService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Throwable;

class StripeController extends Controller
{
    public function __construct(
        protected OrderRepository $orderRepository,
        protected StripeServiceContract $stripeService
    ) {}

    public function create(CreateOrderRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

            $payment = $this->stripeService->create($data);

            $data['vendor_order_id'] = $payment['payment_id'];
            $this->orderRepository->create($data);

            DB::commit();

            return response()->json([
                'payment_id' => $payment['payment_id'],
                'client_secret' => $payment['client_secret'],
            ]);
        } catch (Throwable $exception) {
            DB::rollBack();

            logs()->error('[StripeController::create] '.$exception->getMessage(), [
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
        //        try {
        //            DB::beginTransaction();
        //
        //            $paymentStatus = $this->paypalService->capture($vendorOrderId);
        //
        //            $this->orderRepository->setTransaction(
        //                $vendorOrderId,
        //                PaymentSystemEnum::Paypal,
        //                $paymentStatus
        //            );
        //
        //            Cart::instance('cart')->destroy();
        //
        //            DB::commit();
        //
        //            return response()->json([
        //                'orderId' => $vendorOrderId
        //            ]);
        //        } catch (Throwable $exception) {
        //            DB::rollBack();
        //
        //            logs()->error('[PaypalController::capture] ' . $exception->getMessage(), [
        //                'exception' => $exception,
        //                'vendor_order_id' => $vendorOrderId,
        //            ]);
        //
        //            return response()->json([
        //                'error' => $exception->getMessage(),
        //            ], 422);
        //        }
    }
}
