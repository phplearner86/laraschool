<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $tables = ['users', 'roles', 'role_user'];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->cleanDatabase();
        
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RoleUserTableSeeder::class);
    }

      public function cleanDatabase()
    {
        
        foreach ($this->tables as $table)
         {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
            DB::table($table)->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
        
        
    }
}

