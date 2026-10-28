<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadFeedbackImageRequest extends FormRequest
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
            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp,gif',
                'max:4096',
            ],
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
            'image.required' => 'Vui lòng chọn ảnh cần tải lên.',
            'image.image' => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng jpg, png, webp hoặc gif.',
            'image.max' => 'Kích thước ảnh không được vượt quá 4MB.',
        ];
    }
}
