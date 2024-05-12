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
        Schema::table('punchings', function (Blueprint $table) {
            $table->string('single_punch_type')->nullable();
            $table->string('single_punch_regularised_by')->nullable();
            $table->string('time_group')->nullable();
            $table->boolean('is_unauthorised')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('punchings', function (Blueprint $table) {
            //
        });
    }
};
