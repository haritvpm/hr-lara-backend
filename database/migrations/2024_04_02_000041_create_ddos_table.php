<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDdosTable extends Migration
{
    public function up()
    {
        Schema::create('ddos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
