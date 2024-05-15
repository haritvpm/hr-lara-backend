<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompenGrantedsTable extends Migration
{
    public function up()
    {
        Schema::create('compen_granteds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('aadhaarid');
            $table->date('date_of_work');
            $table->boolean('is_for_extra_hours')->default(0)->nullable();
            $table->timestamps();
        });
    }
}
