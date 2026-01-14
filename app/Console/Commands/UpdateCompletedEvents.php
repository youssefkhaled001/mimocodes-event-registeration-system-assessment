<?php

namespace App\Console\Commands;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateCompletedEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:update-completed-events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark events as completed after 1 hour of there start date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \Log::info('Scheduled UpdateCompletedEvents command executed');
        $expiredEvents = Event::where('status', 'published')
            ->where('date_time', '<', Carbon::now()->subHour())->count();
        $status = Event::where('status', 'published')
            ->where('date_time', '<', Carbon::now()->subHour())
            ->update(['status' => 'completed']);
        if ($expiredEvents > 0 && $status) {
            \Log::info("Successfully updated {$expiredEvents} events to completed.");
        } else {
            \Log::info('No events to update.');
        }
    }
}
