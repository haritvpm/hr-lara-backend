<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEmployeesTable extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('grace_group_id')->nullable();
            $table->foreign('grace_group_id', 'grace_group_fk_9776799')->references('id')->on('grace_times');
        });
    }
}
