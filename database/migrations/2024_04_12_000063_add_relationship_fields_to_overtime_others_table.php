<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToOvertimeOthersTable extends Migration
{
    public function up()
    {
        Schema::table('overtime_others', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_9649609')->references('id')->on('dept_employees');
            $table->unsignedBigInteger('form_id')->nullable();
            $table->foreign('form_id', 'form_fk_9649614')->references('id')->on('ot_form_others');
        });
    }
}
