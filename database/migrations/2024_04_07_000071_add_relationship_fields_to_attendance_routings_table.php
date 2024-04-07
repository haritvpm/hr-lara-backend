<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAttendanceRoutingsTable extends Migration
{
    public function up()
    {
        Schema::table('attendance_routings', function (Blueprint $table) {
            $table->unsignedBigInteger('js_id')->nullable();
            $table->foreign('js_id', 'js_fk_9668048')->references('id')->on('users');
            $table->unsignedBigInteger('as_id')->nullable();
            $table->foreign('as_id', 'as_fk_9668049')->references('id')->on('users');
            $table->unsignedBigInteger('ss_id')->nullable();
            $table->foreign('ss_id', 'ss_fk_9668050')->references('id')->on('users');
        });
    }
}
