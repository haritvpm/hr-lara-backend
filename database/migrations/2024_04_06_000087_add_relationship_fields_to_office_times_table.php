<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToOfficeTimesTable extends Migration
{
    public function up()
    {
        Schema::table('office_times', function (Blueprint $table) {
            $table->unsignedBigInteger('office_id')->nullable();
            $table->foreign('office_id', 'office_fk_9666901')->references('id')->on('administrative_offices');
        });
    }
}
