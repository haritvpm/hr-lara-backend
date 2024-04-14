<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEmployeeOtSettingsTable extends Migration
{
    public function up()
    {
        Schema::table('employee_ot_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_9668596')->references('id')->on('employees');
            $table->unsignedBigInteger('ot_excel_category_id')->nullable();
            $table->foreign('ot_excel_category_id', 'ot_excel_category_fk_9668598')->references('id')->on('ot_categories');
        });
    }
}
