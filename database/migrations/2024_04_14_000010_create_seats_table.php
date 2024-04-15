<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatsTable extends Migration
{
    public function up()
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->unique();
            $table->string('title')->unique();
            $table->boolean('has_files')->default(0)->nullable();
            $table->boolean('has_office_with_employees')->default(0)->nullable();
            $table->boolean('is_js_as_ss')->default(0)->nullable();
            $table->boolean('is_controlling_officer')->default(0)->nullable();
            $table->integer('level');
            $table->timestamps();
        });
    }
}
