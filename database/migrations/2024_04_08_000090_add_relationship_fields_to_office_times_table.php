<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToOfficeTimesTable extends Migration
{
    public function up()
    {
        Schema::table('office_times', function (Blueprint $table) {
            $table->unsignedBigInteger('time_group_id')->nullable();
            $table->foreign('time_group_id', 'time_group_fk_9670916')->references('id')->on('office_time_groups');
        });
    }
}
