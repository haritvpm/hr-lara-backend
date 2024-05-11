<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('yearly_attendances', function (Blueprint $table) {
            $table->float('start_with_cl', 5, 1)->nullable();
            $table->integer('start_with_compen')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('yearly_attendances', function (Blueprint $table) {
            //
        });
    }
};
