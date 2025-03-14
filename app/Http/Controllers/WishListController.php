<?php

namespace App\Http\Controllers;

use App\Enums\WishListEnum;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Throwable;

class WishListController extends Controller
{
    public function add(Request $request, int $productId)
    {
        $data = $request->validate([
            'type' => Rule::enum(WishListEnum::class),
        ]);
        try {
            auth()->user()->addToWishList($productId, WishListEnum::from($data['type']));

            notify()->success('Product was add to wish list.');

            return back();
        } catch (Throwable $throwable) {
            logs()->error("[WishListController] " . $throwable->getMessage(), [
                'exception' => $throwable,
                'productId' => $productId,
                'request' => $data,
            ]);

            notify()->error('Something went wrong.');

            return back();
        }
    }

    public function remove(Request $request, int $productId)
    {
        $data = $request->validate([
            'type' => Rule::enum(WishListEnum::class),
        ]);
        try {
            auth()->user()->removeFromWishList($productId, WishListEnum::from($data['type']));

            notify()->success('Product was deleted to wish list.');

            return back();
        } catch (Throwable $throwable) {
            logs()->error("[WishListController] " . $throwable->getMessage(), [
                'exception' => $throwable,
                'productId' => $productId,
                'request' => $data,
            ]);

            notify()->error('Something went wrong.');

            return back();
        }
    }
}
