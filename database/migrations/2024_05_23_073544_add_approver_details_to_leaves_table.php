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
        Schema::table('leaves', function (Blueprint $table) {
            $table->string('forwarded_by_seat')->nullable();
            $table->string('approver_details')->nullable();
            $table->date('approved_on')->nullable();
            $table->string('prefix')->nullable();
            $table->string('suffix')->nullable();
            $table->date('date_of_joining')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            //
        });
    }
};
