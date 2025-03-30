<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// In the generated migration file
public function up()
{
    Schema::table('tracer_study_responses', function (Blueprint $table) {
        $table->string('phone')->nullable()->change();
        $table->string('email')->nullable()->change();
    });
}

public function down()
{
    Schema::table('tracer_study_responses', function (Blueprint $table) {
        $table->string('phone')->nullable(false)->change();
        $table->string('email')->nullable(false)->change();
    });
}
};
