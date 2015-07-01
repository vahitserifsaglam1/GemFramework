<?php

	 namespace Gem\Components\Facade;
	 class Orm
	 {

		  public function __construct ()
		  {
				$this->orm = new \Gem\Components\Orm\Orm();
				$this->orm->setTable($this->findCalledClassTableVariable());
		  }

		  /**
			* Hangi sınıftan çağrıldığını arar
			* @return mixed
			*/
		  private function findCalledClassTableVariable ()
		  {
				$class = get_called_class ();
				$vars = get_class_vars ($class);
				if ( isset( $vars[ self::TABLE ] ) ) {
					 return $vars[ self::TABLE ];
				}
		  }

		  /**
			* Static kullanım desteği
			* @param $method
			* @param array $params
			* @return mixed
			*/
		  public static function __callStatic ($method, $params = [ ])
		  {

				$instance = new static();
				return call_user_func_array([$instance->orm, $method],$params);

		  }

	 }