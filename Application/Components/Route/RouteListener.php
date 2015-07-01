<?php


	 namespace Gem\Components\Route;


	 class RouteListener
	 {

		  private $routes = [ ];

		  public function __construct ()
		  {

				//

		  }

		  /**
			* Rötaları atar
			* @param array $routes
			* @return $this
			*/
		  public function setRoutes (array $routes = [ ])
		  {
				$this->routes = $routes;

				return $this;
		  }

		  /**
			* @return array
			*/
		  public function getRoutes ()
		  {

				return $this->routes;

		  }

		  /**
			* Rötaya sahip olup olmadığını kontrol eder
			* @param string $name
			* @return bool
			*/
		  public function hasRoute ($name = '')
		  {
				return isset( $this->routes[ $name ] );
		  }
	 }
