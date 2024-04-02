<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeLocationsTable extends Migration
{
    public function up()
    {
        Schema::create('office_locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('location')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
