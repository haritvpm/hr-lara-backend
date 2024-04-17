<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyAttendancesTable extends Migration
{
    public function up()
    {
        Schema::create('monthly_attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('aadhaarid');
            $table->date('month')->nullable();
            $table->float('cl_taken', 3, 1)->nullable();
            $table->integer('compen_taken')->nullable();
            $table->integer('compoff_granted')->nullable();
            $table->integer('total_grace_sec')->nullable();
            $table->integer('total_extra_sec')->nullable();
            $table->string('total_grace_str')->nullable();
            $table->string('total_extra_str')->nullable();
            $table->integer('grace_exceeded_sec')->nullable();
            $table->timestamps();
        });
    }
}
