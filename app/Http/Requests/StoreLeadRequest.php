<?php

namespace App\Http\Requests;

use App\Support\HomeContent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Normalizer;

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
     * Normalise the incoming payload before validation.
     *
     * Browsers and clients may send Vietnamese text in either the composed
     * (NFC) or the decomposed (NFD) Unicode form. Both represent the same
     * string, so they are normalised to NFC to keep comparisons (for example
     * the symptom whitelist) reliable.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => $this->normalizeText($this->input('name')),
            'phone' => $this->normalizeText($this->input('phone')),
            'address' => $this->normalizeText($this->input('address')),
            'coupon_code' => $this->normalizeText($this->input('coupon_code')),
            'variant' => $this->normalizeText($this->input('variant')),
            'plant_type' => $this->normalizeText($this->input('plant_type')),
            'note' => $this->normalizeText($this->input('note')),
            'symptoms' => array_map(
                fn (mixed $symptom): mixed => is_string($symptom)
                    ? $this->normalizeText($symptom)
                    : $symptom,
                (array) $this->input('symptoms', []),
            ),
        ]);
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
            'variant' => ['nullable', 'string', 'max:100'],
            'plant_type' => ['nullable', 'string', 'max:100'],
            'symptoms' => ['nullable', 'array'],
            'symptoms.*' => [Rule::in(HomeContent::symptomOptions())],
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

    /**
     * Convert a string to the composed Unicode form when the intl extension
     * is available, otherwise return it untouched.
     */
    private function normalizeText(mixed $value): mixed
    {
        if (! is_string($value) || $value === '') {
            return $value;
        }

        if (! class_exists(Normalizer::class)) {
            return $value;
        }

        return Normalizer::normalize($value, Normalizer::FORM_C) ?: $value;
    }
}
