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
            'date' => 'date',
        ];
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
