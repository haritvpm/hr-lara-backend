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
        Schema::table('flexi_applications', function (Blueprint $table) {
            $table->string('time_option_str')->nullable();
            $table->string('time_option_current_str')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flexi_applications', function (Blueprint $table) {
            //
        });
    }
};
