<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'thumbnail' => $this->thumbnailUrl,
            'quantity' => $this->quantity,
            'price_info' => [
                'price' => $this->price,
                'discount' => $this->discount,
                'final' => $this->finalPrice,
            ],
            'categories' => $this->whenLoaded('categories', CategoryResource::collection($this->categories)),
            'images' => $this->whenLoaded('images', ImageResource::collection($this->images)),
        ];
    }
}
