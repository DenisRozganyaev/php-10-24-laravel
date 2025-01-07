<?php

namespace App\Http\Requests\Admin\Categories;

use App\Enums\Permissions\CategoryEnum;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    protected $redirectRoute = 'admin.categories.create';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->can(CategoryEnum::PUBLISH->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255', 'unique:categories,name'],
            'parent_id' => ['nullable', 'numeric', 'exists:categories,id'],
        ];
    }
}
