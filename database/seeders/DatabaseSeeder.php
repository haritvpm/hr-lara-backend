<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            GraceTableSeeder::class,
             RolesTableSeeder::class,
             PermissionRoleTableSeeder::class,
             UsersTableSeeder::class,
             RoleUserTableSeeder::class,

            // TestDataSeeder::class,
        ]);
    }
}
