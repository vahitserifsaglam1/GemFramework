<?php

	 /**
	  *
	  * Bu listener örnek olması için yapılmıştır
	  * @author vahitserifsaglam <vahit.serif119@gmail.com>
	  * @packpage Gem\Events
	  */

	 namespace Gem\Listeners;

	 use Gem\Events\TestEvent;

	 class TestEventListener extends EventListener
	 {


		  private $event;

		  public function __construct ()
		  {
				//
		  }

		  /**
			* @param TestEvent $event
			*/
		  public function handle (TestEvent $event)
		  {

				$this->event = $event;
				$this->event;

		  }

	 }
