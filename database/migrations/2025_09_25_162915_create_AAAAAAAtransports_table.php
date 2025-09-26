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
        Schema::create('transports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('transport_type_id')->nullable()->constrained('transport_types')->nullOnDelete();
            $table->foreignId('organization_id')->nullable()->constrained('organizations')->nullOnDelete();
            $table->enum('status', ['scheduled', 'cancelled', 'in_progress', 'completed'])->default('scheduled')->index();
            $table->dateTime('departure_at')->index();
            $table->dateTime('arrival_at')->nullable();
            $table->foreignId('origin_place_id')->nullable()->constrained('places')->nullOnDelete();
            $table->foreignId('destination_place_id')->nullable()->constrained('places')->nullOnDelete();
            $table->decimal('price', 10, 2)->nullable();
            $table->unsignedInteger('duration_minutes')->nullable();
            $table->timestamps();
            $table->index(['origin_place_id', 'departure_at']);
            $table->index(['destination_place_id', 'arrival_at']);
            $table->check('(arrival_at IS NULL OR arrival_at >= departure_at)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transports');
    }
};
