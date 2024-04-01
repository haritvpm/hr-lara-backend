<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToOvertimeSittingsTable extends Migration
{
    public function up()
    {
        Schema::table('overtime_sittings', function (Blueprint $table) {
            $table->unsignedBigInteger('overtime_id')->nullable();
            $table->foreign('overtime_id', 'overtime_fk_9649621')->references('id')->on('overtimes');
        });
    }
}
