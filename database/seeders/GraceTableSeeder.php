<?php

namespace Database\Seeders;

use App\Models\GraceTime;
use Illuminate\Database\Seeder;

class GraceTableSeeder extends Seeder
{
    public function run()
    {

        GraceTime::create([
            'id' => 1,
            'title' => 'default',
            'minutes' => 300,
            'with_effect_from' => '2021-01-01',
        ]);


    }
}
