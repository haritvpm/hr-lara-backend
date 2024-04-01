<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOvertimeOthersTable extends Migration
{
    public function up()
    {
        Schema::create('overtime_others', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('designation');
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('count')->nullable();
            $table->timestamps();
        });
    }
}
