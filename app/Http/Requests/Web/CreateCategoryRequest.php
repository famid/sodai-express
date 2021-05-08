<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
            'name' => 'required|string',
            'status' => 'required|string|in:' . implode(",", [ACTIVE, INACTIVE]),
        ];
    }
    /**
     * @return array
     */
    public function messages(): array {
        return [
            'name.required' => __('Category name field can not be empty'),
            'name.string' => __('Category name field must be string'),
            'status.required' => __('you have to choose one option'),
            'status.string' => __('Category status field must be string'),
        ];
    }
}
