<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'string', 'max:255', Rule::exists('users', 'email')],
            'password' => ['required', 'string', 'min:8', Password::defaults()],
        ]);

        if (! auth()->attempt($data)) {
            return response()->json([
                'status' => 'error',
                'data' => [
                    'message' => 'The provided credentials are incorrect.',
                ],
            ], 422);
        }

        $token = auth()->user()->createToken(
            'authToken',
            [],
            now()->addHour(),
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'token' => $token->plainTextToken,
            ],
        ]);
    }
}
