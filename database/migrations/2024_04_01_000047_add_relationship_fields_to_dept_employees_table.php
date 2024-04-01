<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDeptEmployeesTable extends Migration
{
    public function up()
    {
        Schema::table('dept_employees', function (Blueprint $table) {
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->foreign('designation_id', 'designation_fk_9649562')->references('id')->on('dept_designations');
        });
    }
}
