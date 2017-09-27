<?php

namespace App;

use App\Observers\LessonObserver;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['title', 'topic', 'goals', 'year', 'subject_id'];

    protected static function boot()
   {
        parent::boot();

        static::observe(LessonObserver::class);
   }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

}
