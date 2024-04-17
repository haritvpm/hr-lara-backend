<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAttendanceRoutingsTable extends Migration
{
    public function up()
    {
        Schema::table('attendance_routings', function (Blueprint $table) {
            $table->unsignedBigInteger('viewer_js_as_ss_employee_id')->nullable();
            $table->foreign('viewer_js_as_ss_employee_id', 'viewer_js_as_ss_employee_fk_9675981')->references('id')->on('employees');
            $table->unsignedBigInteger('viewer_seat_id')->nullable();
            $table->foreign('viewer_seat_id', 'viewer_seat_fk_9675982')->references('id')->on('seats');
        });
    }
}
