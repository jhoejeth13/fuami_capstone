<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('title', 200); // Announcement title
            $table->text('content'); // Announcement content
            $table->date('expiry_date'); // When the announcement should stop showing
            $table->enum('priority', ['normal', 'important', 'urgent'])->default('normal');
            $table->boolean('is_active')->default(true); // Whether the announcement is active
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Who created it
            
            // Timestamps
            $table->timestamps(); // created_at and updated_at
            $table->softDeletes(); // deleted_at for soft deletion
            
            // Indexes for better performance
            $table->index(['is_active', 'expiry_date']);
            $table->index('priority');
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('announcements');
    }
};