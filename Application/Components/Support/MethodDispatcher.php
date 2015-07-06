<?php

	 /**
	  * Bu Trait GemFramework'de sınıflara sonradan eklenecek methodları saklaması için yapılmıştır.
	  * @author vahitserifsaglam <vahit.serif119@gmail.com
	  *
	  */

	 namespace Gem\Components\Support;

	 use Closure;

	 /**
	  * Trait MethodDispatcher
	  * @package Gem\Components\Support
	  */
	 trait MethodDispatcher
	 {

		  private $methods = [ ];

		  /**
			* Sınıfın içine yeni method eklemek.
			* @param string $functionName
			* @param callable $callback
			* @return $this
			*/
		  public static function make ($functionName = '', callable $callback = null)
		  {
				Closure::bind ($callback, null, get_class ());
				return new static();
		  }

		  /**
			* Dinamik olarak method çağrımı
			* @param $method
			* @param array $params
			* @return mixed
			*/

		  public function __call ($method, $params = [ ])
		  {
				if ( isset( $this->methods[ $method ] ) ) {
					 return call_user_func_array ($this->methods[ $method ], $params);
				}
		  }
	 }
