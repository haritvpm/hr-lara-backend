<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToOtRoutingsTable extends Migration
{
    public function up()
    {
        Schema::table('ot_routings', function (Blueprint $table) {
            $table->unsignedBigInteger('seat_id')->nullable();
            $table->foreign('seat_id', 'seat_fk_9649626')->references('id')->on('seats');
        });
    }
}
