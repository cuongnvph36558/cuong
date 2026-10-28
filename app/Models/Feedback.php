<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string|null $role
 * @property int $rating
 * @property string $content
 * @property string|null $image
 * @property array<int, string>|null $photos
 * @property bool $is_featured
 * @property int $sort_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable([
    'name',
    'role',
    'rating',
    'content',
    'image',
    'photos',
    'is_featured',
    'sort_order',
])]
class Feedback extends Model
{
    /** @use HasFactory<FeedbackFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'feedbacks';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'photos' => 'array',
            'rating' => 'integer',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
