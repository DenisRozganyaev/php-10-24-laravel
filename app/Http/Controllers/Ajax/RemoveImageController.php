<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Throwable;

class RemoveImageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Image $image)
    {
        try {
            $image->deleteOrFail();

            return response()->json([
                'message' => 'The image was successfully removed.',
            ]);
        } catch (Throwable $th) {
            logs()->error("[RemoveImageController] {$th->getMessage()}", [
                'image' => $image->id,
                'exception' => $th,
            ]);

            return response()->json([
                'message' => 'Oops! Something went wrong.',
            ], 422);
        }
    }
}
