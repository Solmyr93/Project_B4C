<?php

use Illuminate\Database\Seeder;
use Laraspace\User;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        User::create([
            'email' => 'admin@laraspace.in',
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'role' => 'admin',
            'password' => bcrypt('admin@123')
        ]);
    }
}
