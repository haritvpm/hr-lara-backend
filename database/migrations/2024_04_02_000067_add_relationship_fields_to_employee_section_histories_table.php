<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEmployeeSectionHistoriesTable extends Migration
{
    public function up()
    {
        Schema::table('employee_section_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_9653594')->references('id')->on('employees');
            $table->unsignedBigInteger('section_seat_id')->nullable();
            $table->foreign('section_seat_id', 'section_seat_fk_9653598')->references('id')->on('seats');
        });
    }
}
