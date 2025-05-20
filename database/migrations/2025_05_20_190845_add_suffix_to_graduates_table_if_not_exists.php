<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('graduates', function (Blueprint $table) {
            // Only add suffix if it doesn't exist
            if (!Schema::hasColumn('graduates', 'suffix')) {
                $table->string('suffix', 10)->nullable()->after('last_name');
            }
            
            // Only add other_suffix if it doesn't exist
            if (!Schema::hasColumn('graduates', 'other_suffix')) {
                $table->string('other_suffix', 10)->nullable()->after('suffix');
            }
        });
    }

    public function down()
    {
        Schema::table('graduates', function (Blueprint $table) {
            // Only drop if they exist
            if (Schema::hasColumn('graduates', 'suffix')) {
                $table->dropColumn('suffix');
            }
            if (Schema::hasColumn('graduates', 'other_suffix')) {
                $table->dropColumn('other_suffix');
            }
        });
    }
};