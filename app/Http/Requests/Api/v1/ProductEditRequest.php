<?php

namespace App\Http\Requests\Api\v1;

use App\Enums\Permissions\ProductEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->can(ProductEnum::EDIT->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('product')->id;

        return [
            'title' => ['string', 'min:2', 'max:255', Rule::unique('products', 'title')->ignore($id)],
            'SKU' => ['string', 'min:1', 'max:255', Rule::unique('products', 'SKU')->ignore($id)],
            'description' => ['string'],
            'price' => ['numeric', 'min:1'],
            'discount' => ['numeric', 'max:99'],
            'quantity' => ['numeric', 'min:0'],
            'thumbnail' => ['image', 'mimes:jpg,jpeg,png'],
            'categories.*' => ['numeric', 'exists:categories,id'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png'],
        ];
    }
}
