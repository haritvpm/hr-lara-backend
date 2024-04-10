<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEmployeeToSeatsTable extends Migration
{
    public function up()
    {
        Schema::table('employee_to_seats', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_9653604')->references('id')->on('employees');
            $table->unsignedBigInteger('seat_id')->nullable();
            $table->foreign('seat_id', 'seat_fk_9653603')->references('id')->on('seats');
        });
    }
}
