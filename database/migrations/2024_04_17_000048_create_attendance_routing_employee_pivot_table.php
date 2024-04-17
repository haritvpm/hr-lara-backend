<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceRoutingEmployeePivotTable extends Migration
{
    public function up()
    {
        Schema::create('attendance_routing_employee', function (Blueprint $table) {
            $table->unsignedBigInteger('attendance_routing_id');
            $table->foreign('attendance_routing_id', 'attendance_routing_id_fk_9675984')->references('id')->on('attendance_routings')->onDelete('cascade');
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id', 'employee_id_fk_9675984')->references('id')->on('employees')->onDelete('cascade');
        });
    }
}
