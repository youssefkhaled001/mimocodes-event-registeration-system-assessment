<?php

namespace App\Observers;

use App\Models\Event;
use App\Models\Registeration;
use Illuminate\Support\Facades\DB;

class RegisterationObserver
{
    /**
     * Handle the Registration "created" event.
     */
    public function created(Registeration $registration): void
    {
        //
    }

    /**
     * Handle the Registration "updated" event.
     */
    public function updated(Registeration $registration): void
    {
        if ($registration->status == 'cancelled') {
            DB::transaction(function () use ($registration) {
                // lock the event record
                $registration->event->lockForUpdate();

                if ($registration->wasChanged('status') &&
            $registration->getOriginal('status') === 'confirmed' &&
            $registration->status === 'cancelled') {

                    // Find the first waitlisted person for this specific event
                    $nextInLine = $registration->event->firstWaitlisted();

                    if ($nextInLine) {
                        $nextInLine->update(['status' => 'confirmed']);
                    }
                }
            });
        }
    }

    /**
     * Handle the Registration "deleted" event.
     */
    public function deleted(Registeration $registration): void
    {
        //
    }

    /**
     * Handle the Registration "restored" event.
     */
    public function restored(Registeration $registration): void
    {
        //
    }

    /**
     * Handle the Registration "force deleted" event.
     */
    public function forceDeleted(Registeration $registration): void
    {
        //
    }
}
