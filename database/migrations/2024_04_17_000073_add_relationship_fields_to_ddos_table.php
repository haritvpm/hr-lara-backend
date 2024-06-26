<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDdosTable extends Migration
{
    public function up()
    {
        Schema::table('ddos', function (Blueprint $table) {
            $table->unsignedBigInteger('office_id')->nullable();
            $table->foreign('office_id', 'office_fk_9668588')->references('id')->on('administrative_offices');
        });
    }
}
