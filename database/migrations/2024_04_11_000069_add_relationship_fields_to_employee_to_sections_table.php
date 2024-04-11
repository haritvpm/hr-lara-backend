<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEmployeeToSectionsTable extends Migration
{
    public function up()
    {
        Schema::table('employee_to_sections', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id', 'employee_fk_9653609')->references('id')->on('employees');
            $table->unsignedBigInteger('section_id')->nullable();
            $table->foreign('section_id', 'section_fk_9678831')->references('id')->on('sections');
            $table->unsignedBigInteger('attendance_book_id')->nullable();
            $table->foreign('attendance_book_id', 'attendance_book_fk_9653610')->references('id')->on('attendance_books');
        });
    }
}
