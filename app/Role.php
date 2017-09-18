<?php

namespace App;

use App\Observers\RoleObserver;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
   protected $fillable = ['name'];

   public function getRouteKeyName()
   {
       return 'slug';
   }

   protected static function boot()
   {
        parent::boot();

        static::observe(RoleObserver::class);
   }

   public function users()
   {
        return $this->belongsToMany(User::class);
   } 
}
