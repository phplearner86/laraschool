<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teacher = User::whereEmail('b@gmail.com')->first();
        $student = User::whereEmail('a@gmail.com')->first();
        
        $teacher_role = Role::whereName('teacher')->first();
        $student_role = Role::whereName('student')->first();

        $teacher->roles()->attach($teacher_role);
        $student->roles()->attach($student_role);

    }
}
