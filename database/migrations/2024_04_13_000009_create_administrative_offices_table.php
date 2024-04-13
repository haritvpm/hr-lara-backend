<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministrativeOfficesTable extends Migration
{
    public function up()
    {
        Schema::create('administrative_offices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('office_name')->unique();
            $table->timestamps();
        });
    }
}
