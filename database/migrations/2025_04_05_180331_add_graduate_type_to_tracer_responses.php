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
        Schema::table('tracer_study_responses', function (Blueprint $table) {
            // Add graduate type column to differentiate between JHS and SHS
            $table->string('graduate_type')->default('SHS')->after('id');
            
            // Make education fields nullable for JHS graduates
            $table->string('shs_track')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracer_study_responses', function (Blueprint $table) {
            $table->dropColumn('graduate_type');
            $table->string('shs_track')->nullable(false)->change();
        });
    }
};

            $table->string('shs_track')->nullable(false)->change();
