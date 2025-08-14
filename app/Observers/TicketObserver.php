<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Models\Profile;

class TicketObserver
{
    /**
     * Handle the Ticket "created" event.
     */
    public function created(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "updated" event.
     */
    public function updated(Ticket $ticket): void
    {
        $profileIds = $ticket->ticketPersonnel()->pluck('profiles.id');

        foreach ($profileIds as $profileId) {
            $profile = Profile::find($profileId);
            if (!$profile) continue;

            $hasActiveTickets = $profile->ticketPersonnel()
                ->whereIn('request_status', ['accepted', 'in_progress'])
                ->exists();

            if ($profile->status === Profile::STATUS_ONLINE && $hasActiveTickets) {
                $profile->update(['status' => Profile::STATUS_BUSY]);
            } elseif (!$hasActiveTickets && $profile->status !== Profile::STATUS_OFFLINE) {
                $profile->update(['status' => Profile::STATUS_ONLINE]);
            }
        }
    }

    /**
     * Handle the Ticket "deleted" event.
     */
    public function deleted(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "restored" event.
     */
    public function restored(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "force deleted" event.
     */
    public function forceDeleted(Ticket $ticket): void
    {
        //
    }
}
