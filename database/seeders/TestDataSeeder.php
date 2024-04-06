<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AdministrativeOffice;

use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run()
    {

        $offices = [
            [
                'id'             => 1,
                'office_name'    => 'Secretariat',

            ],
            [
                'id'             => 2,
                'office_name'    => 'MLA Hostel',

            ],
        ];
        AdministrativeOffice::insert($offices);



    }
}
