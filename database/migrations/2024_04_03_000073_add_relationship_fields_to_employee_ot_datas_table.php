<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEmployeeOtDatasTable extends Migration
{
    public function up()
    {
        Schema::table('employee_ot_datas', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_9653628')->references('id')->on('employees');
            $table->unsignedBigInteger('ot_excel_category_id')->nullable();
            $table->foreign('ot_excel_category_id', 'ot_excel_category_fk_9653629')->references('id')->on('ot_categories');
        });
    }
}
