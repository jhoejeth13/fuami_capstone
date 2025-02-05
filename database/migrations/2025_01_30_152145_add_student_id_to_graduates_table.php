<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('graduates', function (Blueprint $table) {
            $table->string('ID_student')->after('id'); // Add student_id column, nullable and unique
        });
    }

    public function down()
    {
        Schema::table('graduates', function (Blueprint $table) {
            $table->dropColumn('ID_student'); // Rollback: remove student_id column
        });
    }
};

