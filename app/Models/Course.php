<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'official_url',
        'lecturer',
        'info',
    ];   
    
    //each course has one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //each course van have many lectures, tasks, assessments and scheduled lectures
    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }

   
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function assessment()
    {
        return $this->hasMany(Assessment::class);
    }

    public function scheduledLectures()
    {
        return $this->hasMany(ScheduledLecture::class);
    }

}
