<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class SetLocaleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $cookie = Cookie::forever(
            'locale',
            $request->get('locale', config('app.locale'))
        );

        return response()->json([], 204)->withCookie($cookie);
    }
}
