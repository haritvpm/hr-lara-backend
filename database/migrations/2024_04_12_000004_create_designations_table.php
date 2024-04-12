<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignationsTable extends Migration
{
    public function up()
    {
        Schema::create('designations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('designation')->unique();
            $table->string('designation_mal')->nullable();
            $table->integer('sort_index')->nullable();
            $table->integer('has_punching')->nullable();
            $table->string('designation_without_grade')->nullable();
            $table->string('designation_without_grade_mal')->nullable();
            $table->timestamps();
        });
    }
}