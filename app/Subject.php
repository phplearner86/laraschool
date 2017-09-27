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
     return $this->belongsToMany(Teacher::class)->withPivot('clasroom_id');
   }
}
