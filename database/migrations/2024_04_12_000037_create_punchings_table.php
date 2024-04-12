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
            $table->string('aadhaarid');
            $table->string('designation')->nullable();
            $table->string('section')->nullable();
            $table->datetime('in_datetime')->nullable();
            $table->datetime('out_datetime')->nullable();
            $table->integer('duration_sec')->nullable();
            $table->integer('grace_sec')->nullable();
            $table->integer('extra_sec')->nullable();
            $table->integer('punching_count')->nullable();
            $table->integer('ot_sitting_mins')->nullable();
            $table->integer('ot_nonsitting_mins')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('finalized_by_controller')->nullable();
            $table->timestamps();
        });
    }
}
