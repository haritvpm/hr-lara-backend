<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeToFlexisTable extends Migration
{
    public function up()
    {
        Schema::create('employee_to_flexis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('flexi_minutes');
            $table->date('with_effect_from');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
