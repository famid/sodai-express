<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\EmailOrUsernameValidation;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'product_id' => 'required|integer',
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'description' => 'required|string',
            'unit' => 'required|string',
            'unit_amount' => 'required|numeric',
            'price' => 'required|numeric',
            'in_stock' => 'required|integer',
            'product_discount' => 'required| numeric',
            'tax_percentage' => 'required|numeric',
            'status' => 'required|string|in:' . implode(",", [ACTIVE, INACTIVE]),
            'image' => 'mimes:jpg,bmp,png,jpeg,webp,gif',
        ];
    }
    /**
     * @return array
     */
    public function messages(): array {
        return [

        ];
    }
}
