<?php

	 /**
	  * Bu Sınıf GemFramework'un başlangıç sınıfıdr
	  * Framework le ilgili olaylar ilk olarak bu s�n�fta ger�ekle�ir
	  *
	  * @author vahitserifsaglam <vahit.serif119@gmail.com>
	  * @version 1.0.0
	  * @package Gem\Components
	  */

	 namespace Gem\Components;

	 use Gem\Components\Helpers\Config;
	 use Gem\Components\Helpers\Server;
	 use Gem\Components\Patterns\Facade;
	 use Gem\Components\Patterns\Singleton;
	 use Gem\Components\Security\TypeHint;
	 use Gem\Routes\Collect;

	 /**
	  *
	  * @class Application
	  *
	  */
	 final class Application
	 {

		  use Server, Config;
		  private $frameworkName;
		  private $starter;
		  private $frameworkVersion;

		  /**
			* Framework 'un adı ve versionu girilir,
			* Ve framework başlatılır
			* @param string $frameworkName
			* @param int $frameworkVersion
			*/
		  public function __construct ($frameworkName = '', $frameworkVersion = 1)
		  {

				$this->$frameworkName = $frameworkName;
				$this->frameworkVersion = $frameworkVersion;
				define( 'FRAMEWORK_NAME', $this->frameworkName );
				define( 'FRAMEWORK_VERSION', $this->frameworkVersion );
				$this->starter = $this->singleton ('Gem\Manager\Starter');
				$this->getProvidersAndAlias ();

		  }


		  /**
			* $bool girilirse fonksiyonlar tip yakalaması gerçekleşir
			* @param bool $bool
			*
			*/
		  public function typeHint ($bool = true)
		  {

				if ( true === $bool ) {
					 TypeHint::setErrorHandler ();

				}

		  }


		  /**
			* Yeni bir singleton objesi oluşturur
			* @param mixed $instance
			* @param mixed ...$parameters
			* @return Object
			*
			*/
		  public function singleton ($instance, array $parameters = [ ])
		  {

				return Singleton::make ($instance, $parameters);
		  }


		  ## tetikleyici

		  public function run ()
		  {

				$this->runOthers ();
				new Collect();
				$make = $this->singleton ('Gem\Components\Route\Router');
				$make->run ();

		  }

		  /**
			*
			* Facadeleri yürütür
			*
			*/
		  private function runFacades ()
		  {

				Facade::$instance = $this->starter->getAlias ();
		  }

		  /**
			* Providers ve Facade'leri yürütür
			*/

		  private function  runOthers ()
		  {

				if ( count ($this->starter->getProviders ()) > 0 ) {

					 $this->runProviders ();
				}

				if ( count ($this->starter->getAlias ()) > 0 ) {

					 $this->runFacades ();
				}


		  }

		  /**
			*
			* Providersları yürütür
			*
			*/
		  private function runProviders ()
		  {

				foreach ( $this->starter->getProviders () as $provider ) {

					 new $provider($this);
				}
		  }

		  /**
			* Yeni bir manager objesi döndürür
			* @param $class
			* @return mixed
			*/
		  public function makeManager ($class)
		  {

				$class = "Gem\\Application\\Managers\\" . $class;
				$class = new $class();

				return $class;

		  }

		  /**
			* Uygulamaya dinamik olarak facede ekler
			* @param array $facedes
			* @return \Gem\Components\Application
			*/
		  public function facede ($facedes = [ ])
		  {

				if ( !is_array ($facedes) )
					 $facedes = (array)$facedes;

				$this->starter->setAlias ($facedes);
				return $this;
		  }


		  /**
			* Uygulamaya dinamik olarak provider ekler
			* @param array $provider
			* @return $this
			*/
		  public function provider ($provider = [ ])
		  {

				if ( !is_array ($provider) )
					 $provider = (array)$provider;

				$this->starter->setProviders ($provider);
				return $this;
		  }


		  /**
			* İçeriği belirtilen dosya yolundan çeker
			*/
		  private function getProvidersAndAlias ()
		  {
				$rende = $this->getConfig ('general');
				$this->starter->setAlias ($rende['alias']);
				$this->starter->setProviders ($rende['providers']);
		  }

	 }
