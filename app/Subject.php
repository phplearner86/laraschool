<?php

namespace App;

use App\Observers\SubjectObserver;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name'];

   public function getRouteKeyName()
   {
       return 'slug';
   }

   protected static function boot()
   {
        parent::boot();

        static::observe(SubjectObserver::class);
   }
}
