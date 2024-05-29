<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFlexiApplicationsTable extends Migration
{
    public function up()
    {
        Schema::table('flexi_applications', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_9826409')->references('id')->on('employees');
        });
    }
}
