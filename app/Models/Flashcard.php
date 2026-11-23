<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flashcard extends Model
{
    protected $fillable = [
        'note_id',
        'question',
        'answer',
    ];

    public function note(){ //each flashcard only belongs to a single note
        return $this->belongsTo(Note::class);
    }

}
