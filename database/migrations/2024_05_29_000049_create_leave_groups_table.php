<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('leave_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('groupname')->unique();
            $table->integer('allowed_casual_per_year');
            $table->integer('allowed_compen_per_year');
            $table->integer('allowed_special_casual_per_year')->nullable();
            $table->string('allowed_earned_per_year')->nullable();
            $table->integer('allowed_halfpay_per_year')->nullable();
            $table->integer('allowed_continuous_casual_and_compen')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
