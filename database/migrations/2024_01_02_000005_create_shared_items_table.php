<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shared_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('shared_with_id')->constrained('users')->onDelete('cascade');
            $table->morphs('item');
            $table->timestamps();
            
            $table->index(['user_id', 'shared_with_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shared_items');
    }
};
