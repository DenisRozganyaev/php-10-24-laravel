<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->unique(); // 5 => category-name
            $table->string('name')->unique(); // Category name
            $table->foreignId('parent_id')->nullable()->constrained('categories');
            $table->timestamps();

            $table->index(['parent_id']);
            $table->fullText(['slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
