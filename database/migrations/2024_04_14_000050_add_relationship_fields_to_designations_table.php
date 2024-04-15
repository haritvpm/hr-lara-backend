<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDesignationsTable extends Migration
{
    public function up()
    {
        Schema::table('designations', function (Blueprint $table) {
            $table->unsignedBigInteger('default_time_group_id')->nullable();
            $table->foreign('default_time_group_id', 'default_time_group_fk_9675975')->references('id')->on('office_times');
        });
    }
}
