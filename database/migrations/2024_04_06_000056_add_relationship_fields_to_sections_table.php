<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSectionsTable extends Migration
{
    public function up()
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->unsignedBigInteger('seat_of_controling_officer_id')->nullable();
            $table->foreign('seat_of_controling_officer_id', 'seat_of_controling_officer_fk_9649468')->references('id')->on('seats');
            $table->unsignedBigInteger('seat_of_reporting_officer_id')->nullable();
            $table->foreign('seat_of_reporting_officer_id', 'seat_of_reporting_officer_fk_9649469')->references('id')->on('seats');
            $table->unsignedBigInteger('office_location_id')->nullable();
            $table->foreign('office_location_id', 'office_location_fk_9651305')->references('id')->on('office_locations');
        });
    }
}
