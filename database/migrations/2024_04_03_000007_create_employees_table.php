<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('srismt')->nullable();
            $table->string('name');
            $table->string('name_mal')->nullable();
            $table->string('pen')->nullable();
            $table->string('aadhaarid')->unique();
            $table->string('employee_type');
            $table->string('desig_display')->nullable();
            $table->string('pan')->nullable();
            $table->integer('has_punching')->nullable();
            $table->timestamps();
        });
    }
}
