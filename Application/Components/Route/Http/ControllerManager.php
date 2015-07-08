<?php
	 /**
	  *  Bu Sınıf GemFramework' Route olayında kullanılacak Controllerler için kullanılır.
	  *
	  */
	 namespace Gem\Components\Route\Http;

	 use Exception;

	 class ControllerManager extends Dispatch
	 {

		  /**
			* Controller ataması yapar
			* @param null $controller
			* @return $this
			*/
		  public function setController ($controller = null)
		  {
				$this->setRouteControllerForDispatch ($controller);

				return $this;
		  }

		  /**
			* Callable atamasını engeller
			* @param callable $callable
			* @throws Exception
			*/

		  public function setCallable (callable $callable = null)
		  {

				throw new Exception('%s sınıfından callable ataması yapamassınız', __CLASS__);

		  }
	 }
