<?php
	 /**
	  *
	  *  Bu Sınıf GemFramework'de Route İşlemlerini toplaması için yapılmıştır
	  *  private $routes değerleri değiştirilebilir.
	  * @author vahitserifsaglam <vahit.serif119@gmail.com>
	  *
	  */

	 namespace Gem\Manager\Providers;

	 use Gem\Components\Application;

	 class RouteProvider
	 {

		  private $routes = [

		  ];

		  /**
			* Dinleyiciyi oluşturur ve rötaları o sınıfa atar
			* @param Application $application
			*/
		  public function __construct (Application $application)
		  {

				$listener = $application->singleton ('Gem\Components\Route\RouteListener');
				$listener->setRoutes ($this->routes);
				$application->singleton ('Gem\Components\Route\RouteCollector');

		  }

	 }
