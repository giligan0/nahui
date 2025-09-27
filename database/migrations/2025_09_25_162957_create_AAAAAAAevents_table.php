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
            $table->enum('recurrence', ['none', 'annual', 'weekly', 'monthly'])->default('none')->index(); // traducir enums
            $table->foreignId('address_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('place_id')->nullable()->constrained('places')->nullOnDelete();
            $table->decimal('cost', 10, 2)->nullable();
            $table->char('currency', 3)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['event_category_id', 'recurrence', 'start_at', 'end_at', 'place_id', 'address_id']);
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
