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
            $table->float('cl_marked', precision: 23)->nullable()->change();
           
            $table->float('cl_submitted', precision: 23)->nullable()->change();
            
        });
        Schema::table('yearly_attendances', function (Blueprint $table) {
            $table->float('cl_marked', precision: 23)->nullable()->change();
            $table->float('cl_submitted', precision: 23)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monthly_attendances', function (Blueprint $table) {
            //
        });
    }
};
