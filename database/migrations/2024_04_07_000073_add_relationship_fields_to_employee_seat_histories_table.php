<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEmployeeSeatHistoriesTable extends Migration
{
    public function up()
    {
        Schema::table('employee_seat_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('seat_id')->nullable();
            $table->foreign('seat_id', 'seat_fk_9653579')->references('id')->on('seats');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_9653580')->references('id')->on('employees');
        });
    }
}
