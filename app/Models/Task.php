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
