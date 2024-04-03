<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEmployeeToAcquittancesTable extends Migration
{
    public function up()
    {
        Schema::table('employee_to_acquittances', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_9656012')->references('id')->on('employees');
            $table->unsignedBigInteger('acquittance_id')->nullable();
            $table->foreign('acquittance_id', 'acquittance_fk_9656013')->references('id')->on('acquittances');
        });
    }
}
