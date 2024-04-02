<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtRoutingSeatPivotTable extends Migration
{
    public function up()
    {
        Schema::create('ot_routing_seat', function (Blueprint $table) {
            $table->unsignedBigInteger('ot_routing_id');
            $table->foreign('ot_routing_id', 'ot_routing_id_fk_9653615')->references('id')->on('ot_routings')->onDelete('cascade');
            $table->unsignedBigInteger('seat_id');
            $table->foreign('seat_id', 'seat_id_fk_9653615')->references('id')->on('seats')->onDelete('cascade');
        });
    }
}
