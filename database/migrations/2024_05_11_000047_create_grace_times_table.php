<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGraceTimesTable extends Migration
{
    public function up()
    {
        Schema::create('grace_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->unique();
            $table->integer('minutes');
            $table->date('with_effect_from');
            $table->timestamps();
        });
    }
}
