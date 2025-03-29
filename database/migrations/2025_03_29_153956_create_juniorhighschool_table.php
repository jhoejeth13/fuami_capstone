<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('juniorhighschool', function (Blueprint $table) {
            $table->id();
            $table->string('lrn_number')->unique();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->enum('gender', ['Male', 'Female']);
            $table->string('school_year');
            $table->timestamps(); // creates created_at and updated_at columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('juniorhighschool');
    }
};