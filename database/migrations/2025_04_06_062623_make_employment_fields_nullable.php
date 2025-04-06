<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Doctrine\DBAL\Types\Type;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tracer_study_responses', function (Blueprint $table) {
            // Make employment-related fields nullable to allow for unemployed users
            $table->string('employer_name')->nullable()->change();
            $table->string('organization_type')->nullable()->change();
            $table->string('occupational_classification')->nullable()->change();
            $table->string('job_situation')->nullable()->change();
            $table->string('years_in_company')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracer_study_responses', function (Blueprint $table) {
            // Revert changes - make fields required again
            $table->string('employer_name')->nullable(false)->change();
            $table->string('organization_type')->nullable(false)->change();
            $table->string('occupational_classification')->nullable(false)->change();
            $table->string('job_situation')->nullable(false)->change();
            $table->string('years_in_company')->nullable(false)->change();
        });
    }
};

        Schema::table('tracer_study_responses', function (Blueprint $table) {
            // Revert changes - make fields required again
            $table->string('employer_name')->nullable(false)->change();
            $table->string('organization_type')->nullable(false)->change();
            $table->string('occupational_classification')->nullable(false)->change();
            $table->string('job_situation')->nullable(false)->change();
            $table->string('years_in_company')->nullable(false)->change();
        });

