<?php

namespace App\Http\Requests;

use App\Support\HomeContent;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHomeContentRequest extends FormRequest
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
        $rules = [
            'content' => ['required', 'array'],
        ];

        foreach (HomeContent::schema() as $section) {
            foreach ($section['fields'] as $field) {
                $key = "content.{$section['key']}.{$field['key']}";

                $rules[$key] = match ($field['type']) {
                    'number' => ['nullable', 'numeric', 'min:0'],
                    'list' => ['nullable', 'array'],
                    'image' => ['nullable', 'string', 'max:2048'],
                    'textarea' => ['nullable', 'string', 'max:5000'],
                    default => ['nullable', 'string', 'max:1000'],
                };

                if ($field['type'] === 'list') {
                    $rules[$key] = array_merge($rules[$key], ['*' => ['array']]);

                    foreach ($field['itemFields'] as $itemField) {
                        $itemKey = "{$key}.*.{$itemField['key']}";

                        $rules[$itemKey] = match ($itemField['type']) {
                            'number' => ['nullable', 'numeric', 'min:0'],
                            'image' => ['nullable', 'string', 'max:2048'],
                            'textarea' => ['nullable', 'string', 'max:5000'],
                            default => ['nullable', 'string', 'max:1000'],
                        };
                    }
                }
            }
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'content.required' => 'Nội dung trang chủ không được để trống.',
            'content.*.*.numeric' => 'Các giá trị số không hợp lệ.',
        ];
    }

    /**
     * Normalise the incoming content before it is persisted.
     *
     * @return array<string, mixed>
     */
    public function sanitizedContent(): array
    {
        $content = $this->validated('content', []);
        $normalized = [];

        foreach (HomeContent::schema() as $section) {
            $sectionKey = $section['key'];
            $normalized[$sectionKey] = [];

            foreach ($section['fields'] as $field) {
                $fieldKey = $field['key'];
                $value = $content[$sectionKey][$fieldKey] ?? $field['default'];

                $normalized[$sectionKey][$fieldKey] = $field['type'] === 'list'
                    ? $this->sanitizeList($value, $field)
                    : $this->sanitizeValue($value, $field['type']);
            }
        }

        return $normalized;
    }

    /**
     * Sanitize a list of repeatable items.
     *
     * @param  array<string, mixed>  $field
     * @return array<int, array<string, mixed>>
     */
    private function sanitizeList(mixed $value, array $field): array
    {
        if (! is_array($value)) {
            return $field['default'];
        }

        $items = [];

        foreach ($value as $item) {
            if (! is_array($item)) {
                continue;
            }

            $sanitized = [];

            foreach ($field['itemFields'] as $itemField) {
                $itemKey = $itemField['key'];
                $sanitized[$itemKey] = $this->sanitizeValue(
                    $item[$itemKey] ?? $itemField['default'] ?? null,
                    $itemField['type'],
                );
            }

            $items[] = $sanitized;
        }

        return $items;
    }

    /**
     * Sanitize a single value based on its declared type.
     */
    private function sanitizeValue(mixed $value, string $type): mixed
    {
        if ($value === null) {
            return null;
        }

        return match ($type) {
            'number' => is_numeric($value) ? (float) $value : null,
            default => is_scalar($value) ? trim((string) $value) : null,
        };
    }
}
