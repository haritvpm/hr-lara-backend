<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('employee_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('election')->unique();
            $table->string('kla_id_no')->nullable();
            $table->timestamps();
        });
    }
}
