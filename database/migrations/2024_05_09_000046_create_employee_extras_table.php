<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeExtrasTable extends Migration
{
    public function up()
    {
        Schema::create('employee_extras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('address')->nullable();
            $table->date('date_of_joining_kla')->nullable();
            $table->string('pan')->unique();
            $table->string('klaid')->unique();
            $table->string('electionid')->unique();
            $table->string('mobile')->unique();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }
}
