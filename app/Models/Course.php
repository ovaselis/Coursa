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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }

    public function calendarEvents()
    {
        return $this->hasMany(CalendarEvent::class);
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
