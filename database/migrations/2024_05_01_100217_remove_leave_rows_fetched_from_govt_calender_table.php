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
        if (Schema::hasColumn('govt_calendars', 'leave_rows_fetched'))
        {
        Schema::table('govt_calendars', function (Blueprint $table) {
           $table->dropColumn('leave_rows_fetched');
        });
    }
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
