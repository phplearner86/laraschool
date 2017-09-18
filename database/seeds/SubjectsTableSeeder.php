<?php

use App\Subject;
use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = ['maths', 'history', 'arts & culture'];

        foreach ($subjects as $subject) {
            factory(Subject::class)->create([
                'name' => $subject  
            ]);
        }
    }
}
