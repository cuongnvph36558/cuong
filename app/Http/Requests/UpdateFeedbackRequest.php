<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeedbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (bool) $this->user()?->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'content' => ['required', 'string', 'max:2000'],
            'image' => ['nullable', 'string', 'max:2048'],
            'photos' => ['nullable', 'array'],
            'photos.*' => ['string', 'max:2048'],
            'is_featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên khách hàng.',
            'rating.required' => 'Vui lòng chọn số sao đánh giá.',
            'rating.min' => 'Số sao đánh giá tối thiểu là 1.',
            'rating.max' => 'Số sao đánh giá tối đa là 5.',
            'content.required' => 'Vui lòng nhập nội dung phản hồi.',
            'photos.*' => 'Đường dẫn ảnh không hợp lệ.',
        ];
    }
}
