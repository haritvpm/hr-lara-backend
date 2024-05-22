<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEmployeeToFlexisTable extends Migration
{
    public function up()
    {
        Schema::table('employee_to_flexis', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_9809044')->references('id')->on('employees');
        });
    }
}
