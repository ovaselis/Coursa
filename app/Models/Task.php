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
            'deadline' => 'datetime', //turns into a date time carbon object 
            'is_completed' => 'boolean'

        ];

    }
    //each task has a single course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
