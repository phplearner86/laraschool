<?php  

namespace App\Observers;

use App\Lesson;

class LessonObserver{

    public function creating(Lesson $lesson)
    {
        $lesson->slug = str_slug($lesson->title);
    }
}