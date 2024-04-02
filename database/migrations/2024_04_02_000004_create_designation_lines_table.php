<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignationLinesTable extends Migration
{
    public function up()
    {
        Schema::create('designation_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->unique();
            $table->timestamps();
        });
    }
}
