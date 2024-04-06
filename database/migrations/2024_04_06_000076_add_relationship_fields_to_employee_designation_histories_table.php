<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEmployeeDesignationHistoriesTable extends Migration
{
    public function up()
    {
        Schema::table('employee_designation_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_9654977')->references('id')->on('employees');
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->foreign('designation_id', 'designation_fk_9654978')->references('id')->on('designations');
        });
    }
}
