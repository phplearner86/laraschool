<?php

namespace App;

use App\Observers\RoleObserver;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
   protected $fillable = ['name'];

   protected static function boot()
   {
        parent::boot();

        static::observe(RoleObserver::class);
   }
}
