<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('route_stops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('route_id')->constrained('bus_routes')->cascadeOnDelete();
            $table->foreignId('stop_id')->constrained('stops')->restrictOnDelete();
            $table->unsignedInteger('sequence');
            $table->timestamps();
            $table->unique(['route_id', 'sequence']);
            $table->unique(['route_id', 'stop_id']);
            $table->index(['stop_id', 'sequence']);
            $table->check('sequence > 0');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('route_stops');
    }
};
