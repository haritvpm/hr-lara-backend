<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToGovtCalendarsTable extends Migration
{
    public function up()
    {
        Schema::table('govt_calendars', function (Blueprint $table) {
            $table->unsignedBigInteger('session_id')->nullable();
            $table->foreign('session_id', 'session_fk_9664918')->references('id')->on('assembly_sessions');
        });
    }
}
