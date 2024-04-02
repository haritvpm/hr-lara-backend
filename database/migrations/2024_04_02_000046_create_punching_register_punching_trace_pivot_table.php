<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePunchingRegisterPunchingTracePivotTable extends Migration
{
    public function up()
    {
        Schema::create('punching_register_punching_trace', function (Blueprint $table) {
            $table->unsignedBigInteger('punching_register_id');
            $table->foreign('punching_register_id', 'punching_register_id_fk_9649513')->references('id')->on('punching_registers')->onDelete('cascade');
            $table->unsignedBigInteger('punching_trace_id');
            $table->foreign('punching_trace_id', 'punching_trace_id_fk_9649513')->references('id')->on('punching_traces')->onDelete('cascade');
        });
    }
}
