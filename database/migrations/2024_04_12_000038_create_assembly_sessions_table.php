<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssemblySessionsTable extends Migration
{
    public function up()
    {
        Schema::create('assembly_sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->integer('kla_number');
            $table->integer('session_number')->nullable();
            $table->timestamps();
        });
    }
}