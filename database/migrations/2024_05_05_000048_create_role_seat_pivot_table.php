<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleSeatPivotTable extends Migration
{
    public function up()
    {
        Schema::create('role_seat', function (Blueprint $table) {
            $table->unsignedBigInteger('seat_id');
            $table->foreign('seat_id', 'seat_id_fk_9752429')->references('id')->on('seats')->onDelete('cascade');
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id', 'role_id_fk_9752429')->references('id')->on('roles')->onDelete('cascade');
        });
    }
}
