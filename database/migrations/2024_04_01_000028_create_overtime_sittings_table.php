<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOvertimeSittingsTable extends Migration
{
    public function up()
    {
        Schema::create('overtime_sittings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date')->nullable();
            $table->boolean('checked')->default(0)->nullable();
            $table->timestamps();
        });
    }
}
