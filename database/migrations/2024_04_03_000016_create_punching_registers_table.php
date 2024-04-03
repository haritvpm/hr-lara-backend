<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePunchingRegistersTable extends Migration
{
    public function up()
    {
        Schema::create('punching_registers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('duration')->nullable();
            $table->string('flexi')->nullable();
            $table->string('grace_min')->nullable();
            $table->string('extra_min')->nullable();
            $table->string('designation');
            $table->timestamps();
        });
    }
}
