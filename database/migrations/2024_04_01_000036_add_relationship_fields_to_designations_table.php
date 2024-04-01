<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDesignationsTable extends Migration
{
    public function up()
    {
        Schema::table('designations', function (Blueprint $table) {
            $table->unsignedBigInteger('desig_line_id')->nullable();
            $table->foreign('desig_line_id', 'desig_line_fk_9649387')->references('id')->on('designation_lines');
        });
    }
}
