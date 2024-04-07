<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDesignationsTable extends Migration
{
    public function up()
    {
        Schema::table('designations', function (Blueprint $table) {
            $table->unsignedBigInteger('desig_line_id')->nullable();
            $table->foreign('desig_line_id', 'desig_line_fk_9649387')->references('id')->on('designation_lines');
            $table->unsignedBigInteger('office_times_id')->nullable();
            $table->foreign('office_times_id', 'office_times_fk_9666914')->references('id')->on('office_times');
            $table->unsignedBigInteger('designation_wo_grade_id')->nullable();
            $table->foreign('designation_wo_grade_id', 'designation_wo_grade_fk_9668521')->references('id')->on('designation_without_grades');
        });
    }
}
