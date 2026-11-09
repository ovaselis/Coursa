<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'link',
        'deadline',
        'description',
        'is_completed',


    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'datetime',
            'is_completed' => 'boolean'

        ];

    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
