<?php

namespace WorkCity\Listeners;

use WorkCity\Events\ADelBus;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Request;
use WorkCity\LoginActivity;


class LogADelBus
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
     * @param  ADelBus  $event
     * @return void
     */
    public function handle(ADelBus $event)
    {
        //
        $word = 'admin';
        $word2 = 'coordinator';
        $url = Request::fullUrl();
        $url = explode('/', $url);
        $url = array_flip($url);
        if (isset($url[$word])){
            $sub = 'Administrator';
        }elseif (isset($url[$word2])){
            $sub = 'Coordinator';
        }else{
            $sub = 'User';
        }

        LoginActivity::create([
            'subject' => 'Top '.$sub.' '.$event->user->fullname.' deleted a Business Description',
            'url' => Request::fullUrl(),
            'method' => Request::method(),
            'user_id' => $event->user->id,
            'p_id' => $event->user->p_id,
            'user_agent' => Request::header('User-Agent'),
            'ip_address' => Request::ip()
        ]);
    }
}
