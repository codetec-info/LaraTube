<?php

namespace Laratube\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Laratube\Channel;
use Laratube\Subscription;

class SubscriptionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Channel $channel
     * @return Model|void
     */
    public function store(Channel $channel)
    {
        return $channel->subscriptions()->create([
            'user_id' => auth()->user()->id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Channel $channel
     * @param Subscription $subscription
     * @return void
     * @throws \Exception
     */
    public function destroy(Channel $channel, Subscription $subscription)
    {
        $subscription->delete();

        return response()->json([]);
    }
}
