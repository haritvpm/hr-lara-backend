<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLeaveRelationshipFieldsToEmployeesTable extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {

            $table->unsignedBigInteger('leave_group_id')->nullable();
            $table->foreign('leave_group_id', 'leave_group_fk_9826332')->references('id')->on('leave_groups');
        });
    }
}
