<?php  

namespace App\Observers;

use App\Subject;

class SubjectObserver{

    public function creating(Subject $subject)
    {
        $subject->slug = str_slug($subject->name);
    }
}