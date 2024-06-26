<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToMonthlyAttendancesTable extends Migration
{
    public function up()
    {
        Schema::table('monthly_attendances', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_9668606')->references('id')->on('employees');
        });
    }
}
