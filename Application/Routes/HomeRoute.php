<?php
	 /**
	  *
	  * Bu sınıf örnek bir Route Sınıfıdır.
	  * @author vahitserifsaglam <vahit.serif119@gmail.com>
	  *
	  */
	 namespace Gem\Routes;

	 use Gem\Components\Route\Http\ControllerDispatcher;
	 use Gem\Components\Route\RouteHandleInterface;

	 /**
	  * Class HomeRoute
	  * @package Gem\Routes
	  */
	 class HomeRoute extends ControllerDispatcher implements RouteHandleInterface
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

				$this->setController ('IndexController::boot');
		  }

	 }
