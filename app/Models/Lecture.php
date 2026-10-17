<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $fillable = [
	'course_id',
	'title',
    ];
 
    public function course()
    {
	return $this->belongsTo(Course::class);
    }

    public function notes()
    {
	return $this->hasMany(Note::class);
    }
}
