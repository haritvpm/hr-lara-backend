<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPunchingsTable extends Migration
{
    public function up()
    {
        Schema::table('punchings', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_9658128')->references('id')->on('employees');
            $table->unsignedBigInteger('punchin_trace_id')->nullable();
            $table->foreign('punchin_trace_id', 'punchin_trace_fk_9658818')->references('id')->on('punching_traces');
            $table->unsignedBigInteger('punchout_trace_id')->nullable();
            $table->foreign('punchout_trace_id', 'punchout_trace_fk_9658820')->references('id')->on('punching_traces');
            $table->unsignedBigInteger('leave_id')->nullable();
            $table->foreign('leave_id', 'leave_fk_9666917')->references('id')->on('leaves');
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->foreign('designation_id', 'designation_fk_9667030')->references('id')->on('designations');
            $table->unsignedBigInteger('section_id')->nullable();
            $table->foreign('section_id', 'section_fk_9667031')->references('id')->on('sections');
        });
    }
}
