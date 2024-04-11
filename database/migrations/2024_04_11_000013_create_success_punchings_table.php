<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuccessPunchingsTable extends Migration
{
    public function up()
    {
        Schema::create('success_punchings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('punch_in');
            $table->string('punch_out');
            $table->string('pen');
            $table->string('name')->nullable();
            $table->string('in_device')->nullable();
            $table->datetime('in_time')->nullable();
            $table->string('out_device')->nullable();
            $table->datetime('out_time')->nullable();
            $table->string('at_type')->nullable();
            $table->string('duration')->nullable();
            $table->string('aadhaarid');
            $table->timestamps();
        });
    }
}
