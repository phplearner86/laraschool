<?php

use App\Classroom;
use Illuminate\Database\Seeder;

class ClassroomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classrooms = ['I-1', 'I-2', 'II-1', 'II-2'];

        foreach ($classrooms as $classroom) {
            factory(Classroom::class)->create([
                'label' => $classroom
            ]);
        }
    }
}
