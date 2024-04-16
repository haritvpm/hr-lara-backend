<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AdministrativeOffice;
use App\Models\OfficeLocation;
use App\Models\Seat;
use App\Models\Employee;
use App\Models\Section;

use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run()
    {

        $items = [
            [
                'id'             => 1,
                'office_name'    => 'Secretariat',

            ],
            [
                'id'             => 2,
                'office_name'    => 'MLA Hostel',

            ],
        ];
        foreach ($items as $item) {
            if (!AdministrativeOffice::find($item['id'])) {
                AdministrativeOffice::insert($item);
            }
        }
/////////////////////////////////////////////

        $items = [
            [
                'id'             => 1,
                'location'    => 'Assembly Block',
                'administrative_office_id' => 1,
            ],
            [
                'id'             => 2,
                'location'    => 'Admin Block',
                'administrative_office_id' => 1,
            ],
            [
                'id'             => 3,
                'location'    => 'MLA Hostel',
                'administrative_office_id' => 2,
            ],

        ];

        foreach ($items as $item) {
            if (!OfficeLocation::find($item['id'])) {
                OfficeLocation::insert($item);
            }
        }
 /////////////////////////
        $items = [
            [
                'id'             => 1,
                'slug'    => 'so-it',
                'title' => 'Section Officer(IT)',
                'is_js_as_ss' => 0,
                'is_controlling_officer' => 0,
                'level' => 20,
            ],
            [
                'id'             => 2,
                'slug'    => 'so-eniyamasabha',
                'title' => 'Section Officer(eNiyamasabha)',
                'is_js_as_ss' => 0,
                'is_controlling_officer' => 0,
                'level' => 20,
            ],
            [
                'id'    => 3,
                'slug'  => 'us-it',
                'title' => 'Under secretary(IT)',
                'is_js_as_ss' => 0,
                'is_controlling_officer' => 1,
                'level' =>30,
            ],
            [
                'id'    => 4,
                'slug'  => 'ds-eniyamasabha',
                'title' => 'Deputy secretary(IT)',
                'is_js_as_ss' => 0,
                'is_controlling_officer' => 1,
                'level' =>40,
            ],
            [
                'id'    => 5,
                'slug'  => 'as-4',
                'title' => 'Additional Secretary IV',
                'is_js_as_ss' => 0,
                'is_controlling_officer' => 1,
                'level' =>50,
            ],
            [
                'id'    => 6,
                'slug'  => 'secretary-in-charge',
                'title' => 'Secretary In-Charge',
                'is_js_as_ss' => 0,
                'is_controlling_officer' => 1,
                'level' =>60,
            ],
            [
                'id'    => 7,
                'slug'  => 'secretary',
                'title' => 'Secretary',
                'is_js_as_ss' => 0,
                'is_controlling_officer' => 1,
                'level' =>65,
            ],

        ];

        foreach ($items as $item) {
            if (!Seat::find($item['id'])) {
                Seat::insert($item);
            }
        }
        ////////////////

        $items = [
            [
                'id'     => 1,
                'srismt'  => 'Sri',
                'name' => 'Vishnu MM',
                'aadhaarid' => '123451',

                'status' => 'active',
                'is_shift' => 0,
            ],
            [
                'id'     => 2,
                'srismt'  => 'Smt',
                'name' => 'Mujeeba SI',
                'aadhaarid' => '123452',

                'status' => 'active',
                'is_shift' => 0,
            ],
            [
                'id'     => 3,
                'srismt'  => 'Sri',
                'name' => 'Hari',
                'aadhaarid' => '123422',

                'status' => 'active',
                'is_shift' => 0,
            ],
            [
                'id'     => 4,
                'srismt'  => 'Sri',
                'name' => 'Sreeja',
                'aadhaarid' => '123423',

                'status' => 'active',
                'is_shift' => 0,
            ],
            [
                'id'     => 5,
                'srismt'  => 'Smt',
                'name' => 'Nazia',
                'aadhaarid' => '223423',

                'status' => 'active',
                'is_shift' => 0,
            ],
            [
                'id'     => 6,
                'srismt'  => 'Sri',
                'name' => 'Sachi',
                'aadhaarid' => '323423',

                'status' => 'active',
                'is_shift' => 0,
            ],
            [
                'id'     => 7,
                'srismt'  => 'Sri',
                'name' => 'Abdul Nsar',
                'aadhaarid' => '123523',

                'status' => 'active',
                'is_shift' => 0,
            ],
            [
                'id'     => 8,
                'srismt'  => 'Sri',
                'name' => 'Hari P',
                'aadhaarid' => '153523',

                'status' => 'active',
                'is_shift' => 0,
            ],

            [
                'id'     => 9,
                'srismt'  => 'Sri',
                'name' => 'Shaji C Baby',
                'aadhaarid' => '153423',

                'status' => 'active',
                'is_shift' => 0,
            ],
            [
                'id'     => 10,
                'srismt'  => 'Sri',
                'name' => 'Shyarath',
                'aadhaarid' => '157423',

                'status' => 'active',
                'is_shift' => 0,
            ],
            [
                'id'     => 11,
                'srismt'  => 'Smt',
                'name' => 'Sayin',
                'aadhaarid' => '757423',

                'status' => 'active',
                'is_shift' => 0,
            ],

            [
                'id'     => 12,
                'srismt'  => 'sri',
                'name' => 'Vinod',
                'aadhaarid' => '757423',

                'status' => 'active',
                'is_shift' => 0,
            ],
        ];
        foreach ($items as $item) {
            $emp = Employee::where('aadhaarid',$item['aadhaarid'])->first();
           // if($emp) $emp->delete();

              //  Employee::insert($item);

        }
      ///////////////////////////////////////

      $items = [
        [
            'id'             => 1,
            'name'    => 'IT',
            'short_code'    => 'it',
            'seat_of_controlling_officer_id' => 3,
            'seat_of_reporting_officer_id' => 1,
            'office_location_id' => 2,

        ],
        [
            'id'             => 2,
            'name'    => 'IT(eNiyamasabha)',
            'short_code'    => 'it.en',
            'seat_of_controlling_officer_id' => 3,
            'seat_of_reporting_officer_id' => 2,
            'office_location_id' => 2,
        ],
        [
            'id'             => 3,
            'name'    => 'Office of DS(eNiyamasabha)',
          //  'short_code'    => 'oo.ds.it',
            'seat_of_controlling_officer_id' => 4,
            'seat_of_reporting_officer_id' => 4,
            'office_location_id' => 2,
        ],
        [
            'id'             => 4,
            'name'    => 'Office of HariP',
           // 'short_code'    => 'oo.harip',
            'js_as_ss_employee_id'    => 8,
            'seat_of_controlling_officer_id' => 5,
            'seat_of_reporting_officer_id' => 5,
            'office_location_id' => 2,
        ],
        [
            'id'             => 4,
            'name'    => 'Office of Secretary',
           // 'short_code'    => 'oo.secretary',
            'js_as_ss_employee_id'    => 9, //
            'seat_of_controlling_officer_id' => 5,
            'seat_of_reporting_officer_id' => 5,
            'office_location_id' => 2,
        ],

    ];
    foreach ($items as $item) {
        if (!Section::find($item['id'])) {
            Section::insert($item);
        }
    }
    /////////////////////////

        /////////////////////////

        $users = [
            [
                'id'             => 3,
                'username'       => 'us.it',
                'email'          => 'usit@admin.com',
                'password'       => bcrypt('password'),
                'employee_id'   => 6,
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
                'employee_id'   =>  7,
                'password'       => bcrypt('password'),
                'remember_token' => null,
            ],
            [
                'id'             => 6,
                'username'       => 'harip',
                'email'          => 'harip@kla.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'employee_id'   => 8,
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
