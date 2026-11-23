<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'date',
        'description',
        'link',


    ];

    protected function casts(): array
    {
        return[
            'date' => 'date', //sets date column as date object
        ];
    }
    //each assessment belongs to a single course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
