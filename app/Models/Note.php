<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
	'lecture_id',
	'content',
    ];

    public funtion lecture()
    {
	return $this->belongsTo(Lecture::class);
    }

}
