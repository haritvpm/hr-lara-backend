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
        Schema::table('monthly_attendances', function (Blueprint $table) {
            $table->integer('grace_minutes')->nullable()->default(300);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('single_punchings_regularised')->nullable();
            $table->integer('unauthorised_count')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monthly_attendances', function (Blueprint $table) {
            $table->dropColumn('grace_minutes');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');

        });
    }
};
