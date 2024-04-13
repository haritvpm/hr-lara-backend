<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeOtSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('employee_ot_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('is_admin_data_entry')->default(0)->nullable();
            $table->timestamps();
        });
    }
}
