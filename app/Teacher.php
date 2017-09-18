<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['first_name', 'last_name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
