<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Logout;

class UpdateLastSeenOnLogout
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {
        // Get the logged out user
        $user = $event->user;

        // Check if the user is an instance of Eloquent model
        if ($user instanceof User) {
            // Update the last_seen column to null
            $user->update(['last_seen' => null]);
        }
    }
}
