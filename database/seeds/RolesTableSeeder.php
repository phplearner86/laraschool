<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [ 'student', 'parent', 'teacher', 'admin', 'superadmin'];

        foreach ($roles as $role) {
            factory(Role::class)->create([
                'name' => $role
            ]);
        }
    }
}
