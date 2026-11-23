<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $fillable = [
	'course_id',
	'title',
    'info',
    'date',
    ];
 
    //lecture belongs to a single course and can have many notes

    public function course()
    {
	return $this->belongsTo(Course::class);
    }

    public function notes()
    {
	return $this->hasMany(Note::class);
    }
}
