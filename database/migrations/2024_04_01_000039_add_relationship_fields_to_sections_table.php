<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSectionsTable extends Migration
{
    public function up()
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->unsignedBigInteger('administrative_office_id')->nullable();
            $table->foreign('administrative_office_id', 'administrative_office_fk_9649467')->references('id')->on('administrative_offices');
            $table->unsignedBigInteger('seat_of_controling_officer_id')->nullable();
            $table->foreign('seat_of_controling_officer_id', 'seat_of_controling_officer_fk_9649468')->references('id')->on('seats');
            $table->unsignedBigInteger('seat_of_reporting_officer_id')->nullable();
            $table->foreign('seat_of_reporting_officer_id', 'seat_of_reporting_officer_fk_9649469')->references('id')->on('seats');
        });
    }
}
