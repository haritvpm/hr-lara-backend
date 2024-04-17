<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToOfficeLocationsTable extends Migration
{
    public function up()
    {
        Schema::table('office_locations', function (Blueprint $table) {
            $table->unsignedBigInteger('administrative_office_id')->nullable();
            $table->foreign('administrative_office_id', 'administrative_office_fk_9666862')->references('id')->on('administrative_offices');
        });
    }
}
