<?php

namespace App\Console\Commands;

use App\Mail\EventReminder;
use App\Models\Event;
use App\Models\Registeration;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails to confirmed attendees 24 hours before their event';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \Log::info('Scheduled SendEventReminders command executed');

        // Find events happening in 24 hours (with a 1-hour window)
        $reminderTime = Carbon::now()->addHours(24);
        $windowStart = $reminderTime->copy()->subMinutes(30);
        $windowEnd = $reminderTime->copy()->addMinutes(30);

        $upcomingEvents = Event::where('status', 'published')
            ->whereBetween('date_time', [$windowStart, $windowEnd])
            ->get();

        $emailsSent = 0;

        foreach ($upcomingEvents as $event) {
            // Get all confirmed registrations for this event
            $confirmedRegistrations = Registeration::where('event_id', $event->id)
                ->where('status', 'confirmed')
                ->with('attendee')
                ->get();

            foreach ($confirmedRegistrations as $registration) {
                // Send reminder email
                Mail::to($registration->attendee->email)->queue(new EventReminder($registration));
                $emailsSent++;
            }
        }

        if ($emailsSent > 0) {
            \Log::info("Successfully sent {$emailsSent} event reminder emails for {$upcomingEvents->count()} events.");
        } else {
            \Log::info('No reminder emails to send.');
        }

        return $emailsSent;
    }
}
