<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearlyAttendancesTable extends Migration
{
    public function up()
    {
        Schema::create('yearly_attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('aadhaarid');
            $table->date('year')->nullable();
            $table->float('cl_marked', 3, 1)->nullable();
            $table->float('cl_submitted', 3, 1)->nullable();
            $table->integer('compen_marked')->nullable();
            $table->integer('compen_submitted')->nullable();
            $table->integer('other_leaves_marked')->nullable();
            $table->integer('other_leaves_submitted')->nullable();
            $table->timestamps();
        });
    }
}
