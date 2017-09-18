<?php

use App\Teacher;
use App\User;
use Illuminate\Database\Seeder;

class TeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::whereHas('roles', function($query){
            $query->whereName('teacher');
        })->first();

        factory(Teacher::class)->create([
            'user_id' => $user->id,
            'first_name' => ucfirst($user->name),
        ]);
    }
}
