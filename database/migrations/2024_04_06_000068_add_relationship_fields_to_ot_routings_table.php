<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToOtRoutingsTable extends Migration
{
    public function up()
    {
        Schema::table('ot_routings', function (Blueprint $table) {
            $table->unsignedBigInteger('from_seat_id')->nullable();
            $table->foreign('from_seat_id', 'from_seat_fk_9664920')->references('id')->on('seats');
        });
    }
}
