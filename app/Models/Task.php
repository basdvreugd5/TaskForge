<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Task
 *
 * @property int $id
 * @property int $board_id
 * @property string $title
 * @property string|null $description
 * @property string $status
 * @property string $priority
 * @property array|null $checklist
 * @property \Illuminate\Support\Carbon $hard_deadline
 * @property \Illuminate\Support\Carbon|null $soft_due_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Board $board
 * @property-read array $formatted_checklist
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task query()
 *
 * @mixin \Eloquent
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'board_id',
        'title',
        'description',
        'soft_due_date',
        'hard_deadline',
        'status',
        'priority',
        'checklist',
    ];

    protected $casts = [
        'soft_due_date' => 'datetime',
        'hard_deadline' => 'datetime',
        'checklist' => 'array',
    ];

    /**
     * Get the board that owns the Task.
     */
    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * The tags that belong to the Task.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Get the checklist attribute formatted with defaults and correct types.
     */
    public function getFormattedChecklistAttribute(): array
    {
        return collect($this->checklist ?? [])
            ->map(fn($item) => [
                'title' => $item['title'] ?? '',
                'is_completed' => (bool) ($item['is_completed'] ?? false),
            ])
            ->toArray();
    }
}
