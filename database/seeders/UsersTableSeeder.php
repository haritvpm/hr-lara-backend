<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
            
        $users = [
            [
                'id'             => 1,
                'username'       => 'superadmin',
                'email'          => 'superadmin@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
            ],
            [
                'id'             => 2,
                'username'       => 'itadmin',
                'email'          => 'itadmin@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
            ],
        ];


        User::insert($users);
    }
}
