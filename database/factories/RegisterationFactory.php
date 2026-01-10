<?php

namespace Database\Factories;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registeration>
 */
class RegisterationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // First, select a random event
        $eventId = fake()->randomElement(Event::whereIn('status', ['published', 'completed'])->pluck('id')->toArray());

        // Get attendees who don't already have a registration for this event
        $availableAttendeeIds = Attendee::whereDoesntHave('registrations', function ($query) use ($eventId) {
            $query->where('event_id', $eventId);
        })->pluck('id')->toArray();

        $status = fake()->randomElement(['confirmed', 'waitlisted', 'cancelled']);
        // If no available attendees, fall back to any attendee but the status should be cancelled
        if (empty($availableAttendeeIds)) {
            $availableAttendeeIds = Attendee::where('status', 'cancelled')->pluck('id')->toArray();
            $status = 'cancelled';
        }

        // Make sure also this event have capacity if not make the status cancelled
        $selectedEvent = Event::where('id', $eventId)->first();
        if ($selectedEvent->capacity <= $selectedEvent->registrations()->count()) {
            $status = 'cancelled';
        }

        return [
            'event_id' => $eventId,
            'attendee_id' => fake()->randomElement($availableAttendeeIds),
            'registration_date' => fake()->dateTimeBetween('-1 week', 'now'),
            'status' => $status,
            'payment_status' => fake()->randomElement(['pending', 'paid', 'refunded']),
        ];
    }
}
