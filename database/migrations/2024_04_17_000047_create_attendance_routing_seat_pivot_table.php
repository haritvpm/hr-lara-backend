<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceRoutingSeatPivotTable extends Migration
{
    public function up()
    {
        Schema::create('attendance_routing_seat', function (Blueprint $table) {
            $table->unsignedBigInteger('attendance_routing_id');
            $table->foreign('attendance_routing_id', 'attendance_routing_id_fk_9675983')->references('id')->on('attendance_routings')->onDelete('cascade');
            $table->unsignedBigInteger('seat_id');
            $table->foreign('seat_id', 'seat_id_fk_9675983')->references('id')->on('seats')->onDelete('cascade');
        });
    }
}
