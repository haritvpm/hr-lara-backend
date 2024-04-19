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
        Schema::table('govt_calendars', function (Blueprint $table) {
            $table->boolean('attendance_trace_fetch_complete')->default(0)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('govt_calendars', function (Blueprint $table) {
            //
        });
    }
};
