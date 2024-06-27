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
        Schema::table('leave_form_details', function (Blueprint $table) {
            $table->string('confirmation_info')->nullable();
            $table->string('scaleofpay')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leave_form_details', function (Blueprint $table) {
            //
        });
    }
};
