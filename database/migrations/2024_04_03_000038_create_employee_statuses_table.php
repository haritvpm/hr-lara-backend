<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('employee_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status')->unique();
            $table->timestamps();
        });
    }
}
