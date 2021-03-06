<?php

namespace App;

use App\Observers\SubjectObserver;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name'];


   protected static function boot()
   {
        parent::boot();

        static::observe(SubjectObserver::class);
   }

   public function getRouteKeyName()
   {
       return 'slug';
   }

   public function teachers()
   {
     return $this->belongsToMany(Teacher::class)->withPivot('classroom_id', 'year');
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
