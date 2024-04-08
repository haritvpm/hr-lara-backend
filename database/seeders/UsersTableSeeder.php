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
            [
                'id'             => 3,
                'username'       => 'us.it',
                'email'          => 'usit@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
            ],
            [
                'id'             => 4,
                'username'       => 'so.eniyamasabha',
                'email'          => 'nas@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
            ],
            [
                'id'             => 5,
                'username'       => 'ds.eniyamasabha',
                'email'          => 'dsit@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
            ],
            [
                'id'             => 6,
                'username'       => 'harip',
                'email'          => 'harip@kla.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
            ],
            [
                'id'             => 7,
                'username'       => 'shajic',
                'email'          => 'shaji@kla.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
            ],
        ];

        foreach ($users as $item) {
            if (!User::find($item['id'])) {
                User::insert($item);
            }
        }
      
    }
}
