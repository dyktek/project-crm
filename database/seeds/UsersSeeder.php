<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
        	'name' => 'admin',
        	'first_name' => 'admin',
        	'last_name' => 'admin',
        	'email' => 'admin@admin.com',
	        'password' => bcrypt('123qwe')
        ]);
    }
}
