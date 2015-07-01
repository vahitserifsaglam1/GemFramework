<?php
	 /**
	  * Created by PhpStorm.
	  * User: vserifsaglam
	  * Date: 27.6.2015
	  * Time: 21:13
	  */

	 namespace Gem\Components\Route;

	 class RouteCollector
	 {

		  private $collection;
		  private $filter;

		  private function add ($type = 'GET', $url = '', array $action = [ ])
		  {

				$action = $action['action'];
				$this->collection[ $type ][] = [
					 'action'   => $url,
					 'callback' => $action
				];

		  }

		  /**
			* @param string $action
			* @return array
			*/
		  private function getActionArray ($action = '')
		  {

				return [ 'action' => $action ];

		  }

		  /**
			* Get sorgusu ekler
			* @param string $url
			* @param array $action
			* @return $this
			*/
		  public function get ($url = '', $action = [ ])
		  {
				if ( is_string ($action) ) {
					 $action = $this->getActionArray ($action);
				}

				$this->add ('GET', $url, $action);

				return $this;
		  }

		  /**
			* ppst sorgusu ekler
			* @param string $url
			* @param array $action
			* @return $this
			*/
		  public function post ($url = '', $action = [ ])
		  {
				if ( is_string ($action) ) {
					 $action = $this->getActionArray ($action);
				}

				$this->add ('POST', $url, $action);

				return $this;

		  }

		  /**
			* put sorgusu ekler
			* @param string $url
			* @param array $action
			* @return $this
			*/
		  public function put ($url = '', $action = [ ])
		  {
				if ( is_string ($action) ) {
					 $action = $this->getActionArray ($action);
				}

				$this->add ('PUT', $url, $action);

				return $this;

		  }

		  public function getCollections ()
		  {

				return $this->collection;

		  }

		  /**
			* Get sorgusu ekler
			* @param string $url
			* @param array $action
			* @return $this
			*/
		  public function delete ($url = '', $action = [ ])
		  {
				if ( is_string ($action) ) {
					 $action = $this->getActionArray ($action);
				}

				$this->add ('DELETE', $url, $action);

				return $this;

		  }

		  public function match (array $match = [ ], $url = '', $action = [ ])
		  {


				foreach ( $match as $m ) {
					 $this->add ($m, $url, $action);
				}

				return $this;
		  }

		  public function filter ($name, $pattern = '')
		  {

				$this->filter[ $name ] = $pattern;

				return $this;

		  }

		  public function getFilter ()
		  {

				return $this->filter;

		  }
	 }
