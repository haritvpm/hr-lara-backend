<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToOtFormOthersTable extends Migration
{
    public function up()
    {
        Schema::table('ot_form_others', function (Blueprint $table) {
            $table->unsignedBigInteger('session_id')->nullable();
            $table->foreign('session_id', 'session_fk_9649582')->references('id')->on('assembly_sessions');
        });
    }
}
