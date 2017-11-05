<?php

namespace App;

use App\Event;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['first_name', 'last_name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class)->withPivot('classroom_id', 'year');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
