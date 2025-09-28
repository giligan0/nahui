<?php

namespace App\Observers;

use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonPeriod;

class BookingObserver
{
    // Central helper to generate occupied days array
    protected function nights(Booking $booking): array
    {
        $start = $booking->start_date instanceof \Carbon\Carbon ? $booking->start_date->copy() : \Carbon\Carbon::parse($booking->start_date);
        $end = $booking->end_date instanceof \Carbon\Carbon ? $booking->end_date->copy() : \Carbon\Carbon::parse($booking->end_date);
        $period = CarbonPeriod::create($start, $end->copy()->subDay());
        return collect($period)->map(fn($d) => $d->toDateString())->all();
    }

    /**
     * Validate before create (no overlaps)
     */
    public function creating(Booking $booking): void
    {
        if (!$booking->start_date || !$booking->end_date) {
            return;
        }
        $start = $booking->start_date instanceof \Carbon\Carbon ? $booking->start_date->copy() : \Carbon\Carbon::parse($booking->start_date);
        $end = $booking->end_date instanceof \Carbon\Carbon ? $booking->end_date->copy() : \Carbon\Carbon::parse($booking->end_date);
        if ($end->lte($start)) {
            throw new \RuntimeException('end_date must be greater than start_date');
        }
        $nights = $this->nights($booking);
        if (!$nights) {
            throw new \RuntimeException('Booking must span at least one night.');
        }
        $exists = DB::table('booking_days')
            ->where('accommodation_id', $booking->accommodation_id)
            ->whereIn('day', $nights)
            ->exists();
        if ($exists) {
            throw new \RuntimeException('Selected dates are no longer available (overlap detected).');
        }
    }

    /** Insert booking_days after create */
    public function created(Booking $booking): void
    {
        $this->syncBookingDays($booking);
    }

    /**
     * Handle updates: if dates or accommodation changed and status still active, re-check.
     * If status changed to cancelled/completed -> release days.
     */
    public function updating(Booking $booking): void
    {
        $dirty = $booking->getDirty();
        $statusChanging = array_key_exists('status', $dirty);
        $cancelling = $statusChanging && in_array($dirty['status'], ['cancelled', 'completed'], true);

        $datesChanging = array_intersect(['start_date', 'end_date', 'accommodation_id'], array_keys($dirty));

        if ($cancelling) {
            // nothing to validate; freeing happens in updated()
            return;
        }

        if ($datesChanging) {
            $nights = $this->nights($booking);
            $query = DB::table('booking_days')
                ->where('accommodation_id', $booking->accommodation_id)
                ->whereIn('day', $nights)
                ->where('booking_id', '!=', $booking->id);
            if ($query->exists()) {
                throw new \RuntimeException('Updated dates conflict with another booking.');
            }
        }
    }

    public function updated(Booking $booking): void
    {
        // If cancelled or completed, free days
        if (in_array($booking->status, ['cancelled', 'completed'], true)) {
            DB::table('booking_days')->where('booking_id', $booking->id)->delete();
            return;
        }
        // Otherwise resync (in case dates/accommodation changed)
        $this->syncBookingDays($booking, true);
    }

    /** Soft delete frees nights */
    public function deleting(Booking $booking): void
    {
        if (method_exists($booking, 'isForceDeleting') && !$booking->isForceDeleting()) {
            DB::table('booking_days')->where('booking_id', $booking->id)->delete();
        }
    }

    /** Restoring reclaims nights if still available */
    public function restoring(Booking $booking): void
    {
        // ensure no conflicts before restoring
        if (in_array($booking->status, ['cancelled', 'completed'], true)) {
            return; // do not re-occupy for historical bookings
        }
        $nights = $this->nights($booking);
        $conflict = DB::table('booking_days')
            ->where('accommodation_id', $booking->accommodation_id)
            ->whereIn('day', $nights)
            ->exists();
        if ($conflict) {
            throw new \RuntimeException('Cannot restore booking; dates already taken.');
        }
    }

    public function restored(Booking $booking): void
    {
        if (!in_array($booking->status, ['cancelled', 'completed'], true)) {
            $this->syncBookingDays($booking);
        }
    }

    protected function syncBookingDays(Booking $booking, bool $replace = false): void
    {
        if ($replace) {
            DB::table('booking_days')->where('booking_id', $booking->id)->delete();
        }
        $nights = $this->nights($booking);
        if (!$nights) {
            return;
        }
        $rows = [];
        foreach ($nights as $d) {
            $rows[] = [
                'booking_id' => $booking->id,
                'accommodation_id' => $booking->accommodation_id,
                'day' => $d,
            ];
        }
        if ($rows) {
            DB::table('booking_days')->insert($rows);
        }
    }
}
