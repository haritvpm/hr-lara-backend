<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCompenGrantedsTable extends Migration
{
    public function up()
    {
        Schema::table('compen_granteds', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_9786469')->references('id')->on('employees');
            $table->unsignedBigInteger('leave_id')->nullable();
            $table->foreign('leave_id', 'leave_fk_9786470')->references('id')->on('leaves');
        });
    }
}
