<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
