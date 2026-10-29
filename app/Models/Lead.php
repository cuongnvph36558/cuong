<?php

namespace App\Models;

use Database\Factories\LeadFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string|null $address
 * @property string|null $coupon_code
 * @property string|null $variant
 * @property string|null $plant_type
 * @property array<int, string>|null $symptoms
 * @property string|null $note
 * @property string|null $source
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable([
    'name',
    'phone',
    'address',
    'coupon_code',
    'variant',
    'plant_type',
    'symptoms',
    'note',
    'source',
])]
class Lead extends Model
{
    /** @use HasFactory<LeadFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'symptoms' => 'array',
        ];
    }
}
