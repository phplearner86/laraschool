<?php

namespace App;

use App\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getRouteKeyName()
   {
       return 'name';
   }

   public function roles()
   {
        return $this->belongsToMany(Role::class);
   } 

   public function teacher()
   {
        return $this->hasOne(Teacher::class);
    }

    public function assignLesson($lesson)
    {
      return  $this->teacher->lessons()->save($lesson);
    }
}
