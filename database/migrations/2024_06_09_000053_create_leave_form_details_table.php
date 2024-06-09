<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveFormDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('leave_form_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('dob')->nullable();
            $table->string('post')->nullable();
            $table->string('dept')->nullable();
            $table->string('pay')->nullable();
            $table->date('doe')->nullable();
            $table->date('date_of_confirmation')->nullable();
            $table->string('address')->nullable();
            $table->string('hra')->nullable();
            $table->string('nature')->nullable();
            $table->string('prefix')->nullable();
            $table->string('suffix')->nullable();
            $table->string('last_leave_info')->nullable();
            $table->timestamps();
        });
    }
}
