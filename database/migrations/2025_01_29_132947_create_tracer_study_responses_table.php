<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tracer_study_responses', function (Blueprint $table) {
            $table->id();
            // Personal Information
            $table->string('fullname');
            $table->integer('age');
            $table->string('gender');
            $table->date('birthdate');
            $table->string('civil_status');
            $table->string('religion');
            $table->string('address');
            $table->string('municipality');
            $table->string('province');
            $table->string('region');
            $table->string('postal_code');
            $table->string('country');
            
            // Education Information
            $table->string('shs_track');
            $table->string('year_graduated');
            $table->string('educational_attainment')->nullable();
            
            // Contact Information
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('phone');
            $table->string('email');
            
            // Employment Information
            $table->string('employment_status');
            $table->string('organization_type')->nullable();
            $table->string('occupational_classification')->nullable();
            $table->string('employment_type')->nullable();
            $table->string('work_location')->nullable();
            $table->string('job_situation')->nullable();
            $table->string('years_in_company')->nullable();
            $table->integer('monthly_income')->nullable();
            $table->boolean('job_related_to_shs')->nullable();
            $table->text('reason_staying_job')->nullable();
            $table->string('nature_of_employment')->nullable();
            $table->string('company_name')->nullable();
            $table->string('years_in_business')->nullable();
            $table->integer('self_employed_income')->nullable();
            $table->text('unemployment_reason')->nullable();
            $table->boolean('fuami_factor')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tracer_study_responses');
    }
};