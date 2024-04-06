<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDesignationHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('employee_designation_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }
}
