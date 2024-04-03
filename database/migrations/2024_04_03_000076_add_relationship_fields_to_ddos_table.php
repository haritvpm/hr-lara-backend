<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDdosTable extends Migration
{
    public function up()
    {
        Schema::table('ddos', function (Blueprint $table) {
            $table->unsignedBigInteger('acquittance_id')->nullable();
            $table->foreign('acquittance_id', 'acquittance_fk_9656170')->references('id')->on('acquittances');
        });
    }
}
