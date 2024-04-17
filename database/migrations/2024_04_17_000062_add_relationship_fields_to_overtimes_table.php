<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToOvertimesTable extends Migration
{
    public function up()
    {
        Schema::table('overtimes', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_9649595')->references('id')->on('employees');
            $table->unsignedBigInteger('form_id')->nullable();
            $table->foreign('form_id', 'form_fk_9649600')->references('id')->on('ot_forms');
            $table->unsignedBigInteger('punchin_id')->nullable();
            $table->foreign('punchin_id', 'punchin_fk_9649601')->references('id')->on('punching_traces');
            $table->unsignedBigInteger('punchout_id')->nullable();
            $table->foreign('punchout_id', 'punchout_fk_9649602')->references('id')->on('punching_traces');
        });
    }
}
