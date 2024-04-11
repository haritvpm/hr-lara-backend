<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSuccessPunchingsTable extends Migration
{
    public function up()
    {
        Schema::table('success_punchings', function (Blueprint $table) {
            $table->unsignedBigInteger('punching_id')->nullable();
            $table->foreign('punching_id', 'punching_fk_9658155')->references('id')->on('punchings');
        });
    }
}
