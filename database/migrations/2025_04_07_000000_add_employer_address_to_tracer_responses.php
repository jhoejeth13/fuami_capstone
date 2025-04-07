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
        // Add employer_address to tracer_study_responses table
        Schema::table('tracer_study_responses', function (Blueprint $table) {
            $table->string('employer_address')->nullable()->after('employer_name');
        });

        // Add employer_address to jhs_tracer_responses table
        Schema::table('jhs_tracer_responses', function (Blueprint $table) {
            $table->string('employer_address')->nullable()->after('employer_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove employer_address from tracer_study_responses table
        Schema::table('tracer_study_responses', function (Blueprint $table) {
            $table->dropColumn('employer_address');
        });

        // Remove employer_address from jhs_tracer_responses table
        Schema::table('jhs_tracer_responses', function (Blueprint $table) {
            $table->dropColumn('employer_address');
        });
    }
}; 