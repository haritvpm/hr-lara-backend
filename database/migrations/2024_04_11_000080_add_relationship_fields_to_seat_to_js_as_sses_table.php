<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSeatToJsAsSsesTable extends Migration
{
    public function up()
    {
        Schema::table('seat_to_js_as_sses', function (Blueprint $table) {
            $table->unsignedBigInteger('seat_id')->nullable();
            $table->foreign('seat_id', 'seat_fk_9668590')->references('id')->on('seats');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_9668591')->references('id')->on('employees');
        });
    }
}
