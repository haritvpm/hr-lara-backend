<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGovtCalendarsTable extends Migration
{
    public function up()
    {
        Schema::create('govt_calendars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date')->nullable();
            $table->integer('govtholidaystatus')->nullable();
            $table->integer('restrictedholidaystatus')->nullable();
            $table->integer('bankholidaystatus')->nullable();
            $table->longText('festivallist')->nullable();
            $table->datetime('success_attendance_lastfetchtime')->nullable();
            $table->integer('success_attendance_rows_fetched')->nullable();
            $table->datetime('attendancetodaytrace_lastfetchtime')->nullable();
            $table->integer('attendance_today_trace_rows_fetched')->nullable();
            $table->boolean('is_sitting_day')->default(0)->nullable();
            $table->integer('punching')->nullable();
            $table->time('office_ends_at_time')->nullable();
            $table->timestamps();
        });
    }
}
