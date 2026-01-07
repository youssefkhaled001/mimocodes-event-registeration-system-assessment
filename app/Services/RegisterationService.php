<?php

namespace App\Services;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\Registeration;
use Illuminate\Support\Facades\DB;

class RegisterationService
{
    public static function register(Attendee $attendee, int $event_id)
    {
        // Create a Database Transaction
        return DB::transaction(function () use ($attendee, $event_id) {
            // Avoid Race Condition and lock the event Record
            $event = Event::find($event_id);
            $event->lockForUpdate();

            // Check if Event is Published (Not Completed, Canceled, [Draft if someone tried from outside of the website])
            if ($event->status !== 'published') {
                throw new \Exception('Event is not published');
            }

            // Calculate Capacities
            $maxCapacity = $event->capacity;
            $currentCapacity = Registeration::where('event_id', $event_id)
                ->where('status', 'confirmed')
                ->count();

            // Prevent Duplicate Registrations
            if (Registeration::where('attendee_id', $attendee->id)->where('event_id', $event_id)->exists()) {
                throw new \Exception('You are already registered for this event');
            }
            $registeration = null;
            // Waitlisting & Preventing Exceeding Capacity
            if ($currentCapacity >= $maxCapacity) {
                // Register as waitlisted
                $registeration = Registeration::create([
                    'attendee_id' => $attendee->id,
                    'event_id' => $event_id,
                    'status' => 'waitlisted',
                    'registration_date' => now(),
                    'payment_status' => 'pending',
                ]);
            } else {
                // Register as confirmed
                $registeration = Registeration::create([
                    'attendee_id' => $attendee->id,
                    'event_id' => $event_id,
                    'status' => 'confirmed',
                    'registration_date' => now(),
                    'payment_status' => 'pending',
                ]);
            }

            return $registeration != null;
        });
    }

    public static function cancel(int $registeration_id)
    {
        // Find the registeration
        $registeration = Registeration::find($registeration_id);

        // Check if the registeration exists
        if (! $registeration) {
            throw new \Exception('Registeration not found');
        }

        // Check if the registeration is confirmed or waitlisted
        if ($registeration->status !== 'confirmed' && $registeration->status !== 'waitlisted') {
            throw new \Exception('You can only cancel confirmed or waitlisted registerations');
        }

        // Cancel the registeration
        $registeration->update([
            'status' => 'cancelled',
        ]);
    }
}
