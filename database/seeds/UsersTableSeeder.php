<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['bane', 'anja'];

        foreach ($names as $name) {
            factory(User::class)->create([
                'name' => $name,
                'email' => strtolower(substr($name, 0, 1)) . '@gmail.com',
            ]);
        }
    }
}
