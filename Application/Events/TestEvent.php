<?php

/**
 *
 *  Bu event Örnek Kullanım için oluşturulmuştur
 *
 */
namespace Gem\Events;
use Gem\Events\Event;
class TestEvent extends Event{

    public $user;
    public function __construct(array $user)
    {

        $this->user = $user;

    }

}
