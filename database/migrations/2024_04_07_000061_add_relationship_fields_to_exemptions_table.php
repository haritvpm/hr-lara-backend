<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToExemptionsTable extends Migration
{
    public function up()
    {
        Schema::table('exemptions', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_9649523')->references('id')->on('employees');
            $table->unsignedBigInteger('session_id')->nullable();
            $table->foreign('session_id', 'session_fk_9664919')->references('id')->on('assembly_sessions');
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->foreign('owner_id', 'owner_fk_9668615')->references('id')->on('seats');
        });
    }
}
