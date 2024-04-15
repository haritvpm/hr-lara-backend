<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExemptionsTable extends Migration
{
    public function up()
    {
        Schema::create('exemptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->string('forwarded_by')->nullable();
            $table->boolean('submitted_to_services')->default(0)->nullable();
            $table->integer('approval_status')->nullable();
            $table->timestamps();
        });
    }
}
