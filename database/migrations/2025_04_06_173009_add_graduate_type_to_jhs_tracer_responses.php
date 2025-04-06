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
            // Add graduate type column to differentiate as JHS
            $table->string('graduate_type')->default('JHS')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jhs_tracer_responses', function (Blueprint $table) {
            $table->dropColumn('graduate_type');
        });
    }
};
