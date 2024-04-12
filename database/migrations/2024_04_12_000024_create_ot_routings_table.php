<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtRoutingsTable extends Migration
{
    public function up()
    {
        Schema::create('ot_routings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('last_forwarded_to')->nullable();
            $table->timestamps();
        });
    }
}
