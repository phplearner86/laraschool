<?php

use App\Event;
use App\Teacher;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teacher = Teacher::first();
        $subject = $teacher->subjects->first();
        $title = 'Test';
        $start = Carbon::now()->subHours(5);
        $end = Carbon::now()->subHours(5)->addMinutes(45);

        factory(Event::class)->create([
            'teacher_id' => $teacher->id,        
            'subject_id' => $subject->id,        
            'title' => $title,        
            'start' => $start,        
            'end' => $end,        
        ]);
    }
}
