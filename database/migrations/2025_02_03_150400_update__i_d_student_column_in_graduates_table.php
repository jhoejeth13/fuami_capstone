<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateIDStudentColumnInGraduatesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('graduates', function (Blueprint $table) {
            // Change the column type to string (VARCHAR)
            $table->string('ID_student', 255)->change(); // Adjust length as needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('graduates', function (Blueprint $table) {
            // Revert the column type back to its original state (if needed)
            $table->integer('ID_student')->change();
        });
    }
}