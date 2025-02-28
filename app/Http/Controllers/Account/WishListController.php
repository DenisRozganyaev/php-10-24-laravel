<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $wishes = $request->user()->wishes()->orderBy('product_id')->paginate(10);

        return view('account/wishlist', compact('wishes'));
    }
}
