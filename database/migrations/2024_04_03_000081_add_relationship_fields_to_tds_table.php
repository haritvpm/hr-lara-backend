<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTdsTable extends Migration
{
    public function up()
    {
        Schema::table('tds', function (Blueprint $table) {
            $table->unsignedBigInteger('date_id')->nullable();
            $table->foreign('date_id', 'date_fk_9656610')->references('id')->on('tax_entries');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_9656611')->references('id')->on('seats');
        });
    }
}
