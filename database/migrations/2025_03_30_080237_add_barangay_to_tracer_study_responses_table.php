<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('tracer_study_responses', function (Blueprint $table) {
            // Add the barangay column after the address column
            $table->string('barangay')->after('address');
        });
    }

    public function down()
    {
        Schema::table('tracer_study_responses', function (Blueprint $table) {
            $table->dropColumn('barangay');
        });
    }
};