<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToLeaveFormDetailsTable extends Migration
{
    public function up()
    {
        Schema::table('leave_form_details', function (Blueprint $table) {
            $table->unsignedBigInteger('leave_id')->nullable();
            $table->foreign('leave_id', 'leave_fk_9854829')->references('id')->on('leaves');
        });
    }
}
