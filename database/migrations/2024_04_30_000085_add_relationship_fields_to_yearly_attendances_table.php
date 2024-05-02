<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToYearlyAttendancesTable extends Migration
{
    public function up()
    {
        Schema::table('yearly_attendances', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_9736912')->references('id')->on('employees');
        });
    }
}
