<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->decimal('amount', 15, 2);
            $table->text('description')->nullable();
            $table->string('debtor');
            $table->string('document_url')->nullable();
            $table->enum('status', ['Belum Lunas', 'Lunas'])->default('Belum Lunas');
            $table->boolean('is_shared')->default(false);
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('debts');
    }
};
