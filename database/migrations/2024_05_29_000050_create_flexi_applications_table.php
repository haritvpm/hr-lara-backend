<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlexiApplicationsTable extends Migration
{
    public function up()
    {
        Schema::create('flexi_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('aadhaarid')->nullable();
            $table->integer('flexi_minutes');
            $table->date('with_effect_from');
            $table->string('owner_seat')->nullable();
            $table->string('approved_by')->nullable();
            $table->date('approved_on')->nullable();
            $table->timestamps();
        });
    }
}
