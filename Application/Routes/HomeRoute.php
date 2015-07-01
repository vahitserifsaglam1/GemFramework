<?php
	 /**
	  *
	  * Bu sınıf örnek bir Route Sınıfıdır.
	  * @author vahitserifsaglam <vahit.serif119@gmail.com>
	  *
	  */
	 namespace Gem\Routes;

	 use Gem\Components\Route\Http\ControllerDispatcher;
	 use Gem\Components\Route\RouteHandlerInterface;

	 /**
	  * Class HomeRoute
	  * @package Gem\Routes
	  */
	 class HomeRoute extends ControllerDispatcher implements RouteHandlerInterface
	 {

		  public function __construct ()
		  {
				//
		  }

		  /**
			*  Route olayını hatılar
			* @return void
			*/
		  public function handle ()
		  {

				$this->setController ('Index::open');
		  }

	 }
