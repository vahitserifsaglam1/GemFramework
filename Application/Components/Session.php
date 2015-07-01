<?php

	 /**
	  *
	  *  Gem Framework Session Sınıfı, session'a atama yapmakda kullanılır.
	  * @package Gem\Components
	  * @author vahitserifsaglam <vahit.serif119@gmail.com>
	  *
	  */

	 namespace Gem\Components;
	 use Gem\Components\Session\SecureSessionHandler;

	 class Session extends SecureSessionHandler
	 {

		  public function __construct ()
		  {
				parent::__construct ('AAA');
		  }

		  /**
			* Veriyi döndürür
			* @param string $name
			* @return mixed
			*/
		  public function get ($name)
		  {
				return $this->getValue ($name);
		  }

		  /**
			* @param $name
			* @param $value
			* @return $this
			*/
		  public function set ($name, $value)
		  {
				$this->setValue ($name, $value);
				return $this;
		  }

		  /**
			* Veriyi siler
			* @param $name
			* @return $this
			*/
		  public function delete ($name)
		  {
				if ( isset( $_SESSION[ $name ] ) ) {
					 unset( $_SESSION[ $name ] );
				}

				return $this;
		  }

		  /**
			* Tüm oturum verilerini temilzer
			*/
		  public function flush ()
		  {
				foreach ( $_SESSION as $name => $value ) {
					 unset( $_SESSION[ $name ] );
				}
		  }
	 }
