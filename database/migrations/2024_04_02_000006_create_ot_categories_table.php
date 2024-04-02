<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('ot_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category')->unique();
            $table->boolean('punching')->default(0)->nullable();
            $table->timestamps();
        });
    }
}
