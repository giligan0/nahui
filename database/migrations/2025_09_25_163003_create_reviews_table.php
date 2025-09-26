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
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedTinyInteger('rating');
            $table->string('title', 100)->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['reviewable_type', 'reviewable_id', 'created_at']);
            $table->index(['user_id', 'reviewable_type', 'reviewable_id']);
            $table->check('rating >= 1 AND rating <= 5');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
