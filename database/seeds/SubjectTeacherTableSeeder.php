<?php

use App\Classroom;
use App\Subject;
use App\User;
use Illuminate\Database\Seeder;

class SubjectTeacherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::whereEmail('b@gmail.com')->first();

        $subj1 = Subject::whereName('maths')->first();
        $classrooms1 = Classroom::whereIn('label', ['I-1', 'I-2'])->get();
        $year1 = 'I';

        $subj2 = Subject::whereName('arts & culture')->first();
        $classrooms2 = Classroom::whereIn('label', ['II-1', 'II-2'])->get();
        $year2 = 'II';

        foreach ($classrooms1 as $classroom) {
            $user->teacher->subjects()->attach($subj1->id, [
                'classroom_id' => $classroom->id,
                'year' => $year1,
            ]);
        }

        foreach ($classrooms2 as $classroom) {
            $user->teacher->subjects()->attach($subj2->id, [
                'classroom_id' => $classroom->id,
                'year' => $year2,
            ]);
        }


    }
}
