<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignationWithoutGradesTable extends Migration
{
    public function up()
    {
        Schema::create('designation_without_grades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->unique();
            $table->string('title_mal')->unique();
            $table->timestamps();
        });
    }
}
