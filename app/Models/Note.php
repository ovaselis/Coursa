<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
	'lecture_id',
    'title',
	'content',
    ];

    //each note belongs to a single lecture and can have many flashcards

    public function lecture()
    {
	return $this->belongsTo(Lecture::class);
    }

    public function flashcards()
    {
        return $this->hasMany(Flashcard::class);
    }

}
