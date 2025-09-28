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
        Schema::create('availability_slots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('accommodation_id')->constrained('accommodations')->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            // status values: available, reserved, blocked
            $table->string('status', 20)->default('available')->index();
            $table->timestamps();
            $table->unique(['accommodation_id', 'start_date', 'end_date']);
            $table->index(['accommodation_id', 'start_date']);
            // composite for filtering by status within an accommodation
            $table->index(['accommodation_id', 'status']);
            // enforce non-empty range (end_date inclusive logic can be adjusted in app layer)
            $table->check('start_date <= end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('availability_slots');
    }
};
