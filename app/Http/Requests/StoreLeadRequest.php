<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'coupon_code' => ['nullable', 'string', 'max:50'],
            'plant_type' => ['nullable', 'string', 'max:100'],
            'symptoms' => ['nullable', 'array'],
            'symptoms.*' => [Rule::in([
                'VÀNG LÁ',
                'THỐI RỂ',
                'CÂY CÒI CỌC',
                'CÂY SÂU BỆNH',
                'KHÔNG RA HOA',
                'CÂY HÉO ÚA',
            ])],
            'note' => ['nullable', 'string', 'max:2000'],
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
            'name.required' => 'Vui lòng nhập họ và tên.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.max' => 'Số điện thoại không hợp lệ.',
            'symptoms.*.in' => 'Tình trạng cây trồng không hợp lệ.',
        ];
    }
}
