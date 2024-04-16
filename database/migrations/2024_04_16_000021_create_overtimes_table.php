<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOvertimesTable extends Migration
{
    public function up()
    {
        Schema::create('overtimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('designation');
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('count')->nullable();
            $table->string('slots');
            $table->boolean('has_punching')->default(0)->nullable();
            $table->timestamps();
        });
    }
}
