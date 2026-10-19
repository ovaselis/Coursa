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

    public function lecture()
    {
	return $this->belongsTo(Lecture::class);
    }

}
