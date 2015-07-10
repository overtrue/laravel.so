<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        # DB::table('users')->truncate();

        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@laravel.so',
                'password' => Hash::make('password'),
                'is_admin' => '1',
            ],
            [
                'username' => 'overtrue',
                'email' => 'i@overtrue.me',
                'password' => Hash::make('password'),
                'is_admin' => '1',
            ],
        ];

        DB::table('users')->insert($users);
    }
}
