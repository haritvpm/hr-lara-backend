<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeTimesTable extends Migration
{
    public function up()
    {
        Schema::create('office_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('groupname');
            $table->string('description')->nullable();
            $table->time('fn_from')->nullable();
            $table->time('fn_to')->nullable();
            $table->time('an_from')->nullable();
            $table->time('an_to')->nullable();
            $table->integer('flexi_minutes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
