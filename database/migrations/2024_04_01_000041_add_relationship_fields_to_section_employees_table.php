<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSectionEmployeesTable extends Migration
{
    public function up()
    {
        Schema::table('section_employees', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_9649478')->references('id')->on('employees');
            $table->unsignedBigInteger('section_id')->nullable();
            $table->foreign('section_id', 'section_fk_9649484')->references('id')->on('sections');
            $table->unsignedBigInteger('attendance_book_id')->nullable();
            $table->foreign('attendance_book_id', 'attendance_book_fk_9649485')->references('id')->on('attendance_books');
        });
    }
}
