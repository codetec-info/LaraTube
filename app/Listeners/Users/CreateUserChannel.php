<?php

namespace Laratube\Listeners\Users;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateUserChannel
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // Get user from the RegisteredController Registered event
        $event->user->channel()->create([
            'name' => $event->user->name,
        ]);
    }
}
