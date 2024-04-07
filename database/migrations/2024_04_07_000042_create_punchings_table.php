<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePunchingsTable extends Migration
{
    public function up()
    {
        Schema::create('punchings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('duration')->nullable();
            $table->string('flexi')->nullable();
            $table->integer('grace')->nullable();
            $table->integer('extra')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('calc_complete')->nullable();
            $table->integer('ot_claimed_mins')->nullable();
            $table->integer('ot_extra_mins')->nullable();
            $table->integer('punching_status')->nullable();
            $table->timestamps();
        });
    }
}
