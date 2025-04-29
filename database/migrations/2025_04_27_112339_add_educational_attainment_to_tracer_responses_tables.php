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
        Schema::table('jhs_tracer_responses', function (Blueprint $table) {
            $table->string('educational_attainment')->nullable();
        });

        Schema::table('tracer_study_responses', function (Blueprint $table) {
            $table->string('educational_attainment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jhs_tracer_responses', function (Blueprint $table) {
            $table->dropColumn('educational_attainment');
        });

        Schema::table('tracer_study_responses', function (Blueprint $table) {
            $table->dropColumn('educational_attainment');
        });
    }
};
