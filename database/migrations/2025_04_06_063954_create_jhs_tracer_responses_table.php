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
        Schema::create('jhs_tracer_responses', function (Blueprint $table) {
            $table->id();
            
            // Personal Information
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->integer('age');
            $table->string('gender');
            $table->date('birthdate');
            $table->string('civil_status');
            $table->string('religion');
            
            // Address Information
            $table->string('address')->nullable();
            $table->string('barangay');
            $table->string('municipality');
            $table->string('province');
            $table->string('region');
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable()->default('Philippines');
            
            // Education Information (JHS specific)
            $table->year('year_graduated');
            
            // Contact Information
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            
            // Employment Information
            $table->string('employment_status');
            $table->string('employer_name')->nullable();
            $table->string('organization_type')->nullable();
            $table->string('occupational_classification')->nullable();
            $table->string('job_situation')->nullable();
            $table->string('years_in_company')->nullable();
            $table->string('unemployment_reason')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jhs_tracer_responses');
    }
};

            $table->string('address')->nullable();
            $table->string('barangay');
            $table->string('municipality');
            $table->string('province');
            $table->string('region');
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable()->default('Philippines');
            
            // Education Information (JHS specific)
            $table->year('year_graduated');
            
            // Contact Information
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            
            // Employment Information
            $table->string('employment_status');
            $table->string('employer_name')->nullable();
            $table->string('organization_type')->nullable();
            $table->string('occupational_classification')->nullable();
            $table->string('job_situation')->nullable();
            $table->string('years_in_company')->nullable();
            $table->string('unemployment_reason')->nullable();
            
            $table->timestamps();
