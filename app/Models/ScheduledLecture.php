<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduledLecture extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'date',
        'time_from',
        'time_to',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date', //turns date into a carbon date object
        ];
    }

    public function course()
    {
        return $this->belongsTo(Course::class); // sheduled lecture belongs to a single course
    }
}
