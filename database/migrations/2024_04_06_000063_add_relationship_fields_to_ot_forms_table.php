<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToOtFormsTable extends Migration
{
    public function up()
    {
        Schema::table('ot_forms', function (Blueprint $table) {
            $table->unsignedBigInteger('session_id')->nullable();
            $table->foreign('session_id', 'session_fk_9649566')->references('id')->on('sessions');
        });
    }
}
