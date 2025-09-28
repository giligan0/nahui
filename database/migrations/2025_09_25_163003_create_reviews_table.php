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
            // add cascade on delete
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Polymorphic relation to any reviewable model (e.g., Place, Restaurant, Event, etc.)
            $table->morphs('reviewable'); // creates unsignedBigInteger reviewable_id & string reviewable_type + index
            $table->unsignedTinyInteger('rating');
            $table->string('title', 100)->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['user_id','reviewable_type','reviewable_id','deleted_at']);
            $table->index(['reviewable_type', 'reviewable_id', 'created_at']);
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
