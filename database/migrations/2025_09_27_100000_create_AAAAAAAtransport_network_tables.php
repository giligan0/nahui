<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // IMPORTANT!!! MAKE THIS GTFS COMPLIANT https://developers.google.com/transit/gtfs?hl=es-419


    // to do: make everything into separate migrations?
    // to do: add indexes for common queries (e.g., active routes by municipality, stop, etc.)
    // to do: consider spatial type point for mysql
    // to do: consider adding service calendars for specific dates (holidays, special events)
    // to do: consider adding user feedback/reviews for stops/routes
    // to do: consider adding historical data tracking (e.g., past routes, schedules, etc.)
    public function up(): void
    {
        // 1) Stops where buses pick up/drop off passengers
        Schema::create('stops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->foreignId('municipality_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('address_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('place_id')->nullable()->constrained('places')->nullOnDelete();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('is_terminal')->default(false)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['municipality_id', 'is_active']);
            $table->index(['latitude', 'longitude']);
        });

        // 2) Routes (intercity expreso/ruteado and urban routes)
        Schema::create('bus_routes', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->string('code')->nullable()->index();
            $table->string('name');
            $table->enum('scope', ['intercity', 'urban'])->index();
            $table->enum('service_pattern', ['expreso', 'ruteado'])->default('ruteado')->index();
            $table->foreignId('transport_type_id')->nullable()->constrained('transport_types')->nullOnDelete();
            $table->foreignId('organization_id')->nullable()->constrained('organizations')->nullOnDelete();
            $table->foreignId('origin_place_id')->nullable()->constrained('places')->nullOnDelete();
            $table->foreignId('destination_place_id')->nullable()->constrained('places')->nullOnDelete();
            $table->foreignId('municipality_id')->nullable()->constrained()->nullOnDelete(); // for urban routes
            $table->decimal('distance_km', 8, 2)->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['scope', 'service_pattern']);
            $table->index(['origin_place_id', 'destination_place_id']);
        });

        // 3) Many-to-many: Organizations <-> Routes (operators, owners, etc.)
        Schema::create('organization_route', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('route_id')->constrained('bus_routes')->cascadeOnDelete();
            // $table->enum('role', ['operator', 'owner', 'regulator'])->default('operator');
            // $table->boolean('is_primary')->default(false);
            $table->timestamps();
            $table->unique(['organization_id', 'route_id']);
            $table->index(['route_id', 'role']);
        });

        // 4) Route stops (ordered list of stops along a route)
        Schema::create('route_stops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('route_id')->constrained('bus_routes')->cascadeOnDelete();
            $table->foreignId('stop_id')->constrained('stops')->restrictOnDelete();
            $table->unsignedInteger('sequence');
            // $table->decimal('distance_along_km', 8, 2)->nullable();
            // $table->unsignedSmallInteger('typical_travel_minutes')->nullable(); // from previous stop
            // $table->boolean('is_pickup_only')->default(false);
            // $table->boolean('is_dropoff_only')->default(false);
            $table->timestamps();
            $table->unique(['route_id', 'sequence']);
            $table->unique(['route_id', 'stop_id']);
            $table->index(['stop_id', 'sequence']);
        });

        // 5) Optional: saved path/geometry for a route (polyline)
        Schema::create('route_paths', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('route_id')->constrained('bus_routes')->cascadeOnDelete();
            $table->json('path'); //->nullable(); // GeoJSON LineString or array of lat/lng points
            // $table->string('source')->nullable(); // e.g., 'manual', 'gps_trace'
            $table->decimal('length_km', 8, 2)->nullable();
            $table->timestamps();
            $table->index(['route_id']);
        });

        // 6) Recurrent schedules (headways/windows by day of week)
        // to do: review if this table is necessary
        Schema::create('route_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('route_id')->constrained('bus_routes')->cascadeOnDelete();
            $table->unsignedTinyInteger('days_mask')->default(127); // 1 bit per day (Mon=1<<0 .. Sun=1<<6)
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->unsignedSmallInteger('headway_minutes')->nullable(); // e.g., every 15 min
            // $table->string('notes')->nullable();
            $table->timestamps();
            $table->index(['route_id', 'days_mask']);
        });

        // 7) Per-trip stop times (planned/actual times for a specific transport instance)
        // to do: review if this table is necessary
        // we dont need this table
        Schema::create('transport_stop_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('transport_id')->constrained('transports')->cascadeOnDelete();
            $table->foreignId('stop_id')->constrained('stops')->restrictOnDelete();
            $table->unsignedInteger('sequence');
            $table->dateTime('arrival_at')->nullable();
            $table->dateTime('departure_at')->nullable();
            $table->enum('status', ['scheduled', 'skipped', 'completed'])->default('scheduled');
            $table->integer('delay_minutes')->default(0);
            $table->timestamps();
            $table->unique(['transport_id', 'sequence']);
            $table->index(['transport_id', 'stop_id']);
            $table->check('(departure_at IS NULL OR arrival_at IS NULL OR departure_at >= arrival_at)');
        });

        // 8) Add route reference to existing transports table (nullable to keep backward compatibility)
        // to do: review if this table is necessary
        Schema::table('transports', function (Blueprint $table) {
            $table->foreignId('route_id')->nullable()->after('organization_id')->constrained('bus_routes')->nullOnDelete();
            $table->index(['route_id', 'departure_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove FK and column from transports first
        Schema::table('transports', function (Blueprint $table) {
            if (Schema::hasColumn('transports', 'route_id')) {
                $table->dropIndex(['route_id', 'departure_at']);
                $table->dropConstrainedForeignId('route_id');
            }
        });

        Schema::dropIfExists('transport_stop_times');
        Schema::dropIfExists('route_schedules');
        Schema::dropIfExists('route_paths');
        Schema::dropIfExists('route_stops');
        Schema::dropIfExists('organization_route');
        Schema::dropIfExists('bus_routes');
        Schema::dropIfExists('stops');
    }
};
