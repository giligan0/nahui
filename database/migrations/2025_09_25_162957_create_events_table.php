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
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->foreignId('event_category_id')->nullable()->constrained('event_categories')->nullOnDelete();
            $table->string('author');
            $table->text('description')->nullable();
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            // recurrence values: none, annual, weekly, monthly (stored as string for flexibility / i18n)
            $table->string('recurrence', 20)->default('none')->index();
            $table->foreignId('address_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('place_id')->nullable()->constrained('places')->nullOnDelete();
            $table->decimal('cost', 10, 2)->nullable();
            $table->char('currency', 3)->nullable();
            $table->timestamps();
            $table->softDeletes();
            // Replacing overly wide composite index with smaller targeted ones for common query patterns
            $table->index(['start_at']);
            $table->index(['event_category_id', 'start_at']);
            $table->index(['place_id', 'start_at']);
            $table->index(['recurrence', 'start_at']);
            $table->check('(end_at IS NULL OR end_at >= start_at)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
