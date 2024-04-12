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
            $table->timestamps();
        });
    }
}
