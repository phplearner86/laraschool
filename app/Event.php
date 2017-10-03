<?php

namespace App;

use App\Subject;
use App\Teacher;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['subject_id', 'title', 'start', 'end'];
    
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
