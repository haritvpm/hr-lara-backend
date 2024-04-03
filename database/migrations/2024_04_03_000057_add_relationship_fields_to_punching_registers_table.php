<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPunchingRegistersTable extends Migration
{
    public function up()
    {
        Schema::table('punching_registers', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_9649504')->references('id')->on('employees');
            $table->unsignedBigInteger('success_punching_id')->nullable();
            $table->foreign('success_punching_id', 'success_punching_fk_9649512')->references('id')->on('success_punchings');
        });
    }
}
