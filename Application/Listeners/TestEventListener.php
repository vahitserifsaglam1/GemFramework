<?php

/**
 *
 * Bu listener örnek olması için yapılmıştır
 *
 */

namespace Gem\Listeners;
use Gem\Events\TestEvent;
class TestEventListener extends  EventListener{

    public function __construct()
    {

    }

    public function handle(TestEvent $event)
    {

        print_r($event->user);

    }

}