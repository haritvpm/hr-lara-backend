<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeptDesignationsTable extends Migration
{
    public function up()
    {
        Schema::create('dept_designations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->unique();
            $table->integer('max_persons')->nullable();
            $table->timestamps();
        });
    }
}
