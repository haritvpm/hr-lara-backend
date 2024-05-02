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
            $table->float('cl_submitted', 3, 1)->nullable();
            $table->integer('compen_submitted')->nullable();
            $table->integer('other_leaves_marked')->nullable();
            $table->integer('other_leaves_submitted')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monthly_attendances', function (Blueprint $table) {
            $table->dropColumn('cl_submitted');
            $table->dropColumn('compen_submitted');
            $table->dropColumn('other_leaves_marked');
            $table->dropColumn('other_leaves_submitted');
        });
    }
};
