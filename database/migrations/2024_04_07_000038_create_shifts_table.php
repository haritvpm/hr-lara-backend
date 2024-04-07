<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->datetime('from')->nullable();
            $table->datetime('upto')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
