<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePunchingDevicesTable extends Migration
{
    public function up()
    {
        Schema::create('punching_devices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('device')->unique();
            $table->string('loc_name')->nullable();
            $table->string('entry_name')->nullable();
            $table->timestamps();
        });
    }
}
