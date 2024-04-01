<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSenioritiesTable extends Migration
{
    public function up()
    {
        Schema::create('seniorities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sortindex');
            $table->timestamps();
        });
    }
}
