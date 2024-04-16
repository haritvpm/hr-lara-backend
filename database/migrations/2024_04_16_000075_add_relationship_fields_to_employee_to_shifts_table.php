<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEmployeeToShiftsTable extends Migration
{
    public function up()
    {
        Schema::table('employee_to_shifts', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_9656286')->references('id')->on('employees');
            $table->unsignedBigInteger('shift_id')->nullable();
            $table->foreign('shift_id', 'shift_fk_9656287')->references('id')->on('shifts');
        });
    }
}
