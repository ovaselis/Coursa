<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    protected $fillable = [
        'course_id',
        'type',
        'title',
        'description',
        'starts_at',
        'ends_at',
        'is_completed',
    ];

    protected function casts(): array
    {
    return [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_completed' => 'boolean',
    ];
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
