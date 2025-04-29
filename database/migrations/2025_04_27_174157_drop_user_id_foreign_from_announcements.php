<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('announcements', function (Blueprint $table) {
            // First drop the foreign key constraint
            $table->dropForeign(['user_id']);
            
            // Then drop the index
            $table->dropIndex(['user_id']);
            
            // Now we can drop the columns
            $table->dropColumn(['user_id', 'priority', 'is_active']);
        });
    }

    public function down()
    {
        Schema::table('announcements', function (Blueprint $table) {
            // If you need to rollback (not recommended after running)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('priority', ['normal', 'important', 'urgent'])->default('normal');
            $table->boolean('is_active')->default(true);
        });
    }
};