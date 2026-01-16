<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Added Hourly Schedule to check completed events and change their status to completed
Schedule::command('events:update-completed-events')->hourly();

// Added Hourly Schedule to send 24-hour reminder emails to confirmed attendees
Schedule::command('events:send-reminders')->hourly();
