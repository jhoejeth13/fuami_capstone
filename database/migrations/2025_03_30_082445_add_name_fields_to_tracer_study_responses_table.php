<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('tracer_study_responses', function (Blueprint $table) {
            // Add new name fields (place them where appropriate in your schema)
            $table->string('first_name')->after('fullname')->nullable();
            $table->string('middle_name')->after('first_name')->nullable();
            $table->string('last_name')->after('middle_name')->nullable();
            $table->string('suffix')->after('last_name')->nullable();
            
            // Optional: If you want to keep the fullname field but make it nullable
            $table->string('fullname')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('tracer_study_responses', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'middle_name', 'last_name', 'suffix']);
            // If you modified fullname, revert it
            $table->string('fullname')->nullable(false)->change();
        });
    }
};