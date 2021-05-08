<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'category_id' => 'required|integer',
            'name' => 'required|string',
        ];
    }
    /**
     * @return array
     */
    public function messages(): array {
        return [
            'name.required' => __('Category name field can not be empty'),
            'name.string' => __('Category name field must be string'),
            'category_id.required' => __('Category id field can not be empty'),
            'category_id.integer' => __('Category id field must be integer'),
        ];
    }
}
