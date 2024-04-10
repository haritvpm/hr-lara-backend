<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtFormsTable extends Migration
{
    public function up()
    {
        Schema::create('ot_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('creator');
            $table->string('owner');
            $table->string('submitted_by')->nullable();
            $table->string('submitted_names')->nullable();
            $table->date('submitted_on')->nullable();
            $table->integer('form_no')->nullable();
            $table->date('duty_date')->nullable();
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->string('remarks')->nullable();
            $table->string('worknature')->nullable();
            $table->timestamps();
        });
    }
}
