<?php

/**
 *
 *  Bu event Örnek Kullanım için oluşturulmuştur
 *  @author vahitserifsaglam1 <vahit.serif119@gmail.com>
 *  @packpage Gem\Events
 */
namespace Gem\Events;
use Gem\Components\Http\UserManager;
use Gem\Events\Event;
class TestEvent extends Event{

    /**
     * @var UserManager
     */
    public $user;

    /**
     * @param UserManager $user
     */
    public function __construct(UserManager $user)
    {

        $this->user = $user;

    }

}
