<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeSectionHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('employee_section_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_from');
            $table->date('date_to')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }
}
