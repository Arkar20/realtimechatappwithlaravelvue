<?php

namespace App\Providers\Listenters;

use App\Providers\Events\ChatEvent;
use Illuminate\Http\Client\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewChat
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ChatEvent  $event
     * @return void
     */
    public function handle(ChatEvent $event,Request $request)
    {

    }
}
