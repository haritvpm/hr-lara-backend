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
            $table->date('month');
            $table->float('total_cl', 3, 1)->nullable();
            $table->integer('total_compen')->nullable();
            $table->integer('total_compen_off_granted')->nullable();
            $table->timestamps();
        });
    }
}
