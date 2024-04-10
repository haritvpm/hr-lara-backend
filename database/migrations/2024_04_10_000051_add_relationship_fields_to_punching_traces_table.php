<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPunchingTracesTable extends Migration
{
    public function up()
    {
        Schema::table('punching_traces', function (Blueprint $table) {
            $table->unsignedBigInteger('punching_id')->nullable();
            $table->foreign('punching_id', 'punching_fk_9658154')->references('id')->on('punchings');
        });
    }
}
