<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('juniorhighschool', function (Blueprint $table) {
            $table->date('birthdate')->nullable()->after('gender');
            $table->string('address', 255)->nullable()->after('birthdate');
        });
    }
    
    public function down()
    {
        Schema::table('juniorhighschool', function (Blueprint $table) {
            $table->dropColumn(['birthdate', 'address']);
        });
    }
};
