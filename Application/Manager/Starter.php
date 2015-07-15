<?php
	 /**
	  *
	  *  Bu Sınıf GemFramework'un başlangıç manager'ı dır, facede alias ları vs tutulur.
	  *
	  */

	 namespace Gem\Manager;

	 class Starter
	 {

		 private $alias = [];
		  private $providers = [ ];

		  /**
			* Alias'ları atar
			* @param array $alias
			*/
		 public function setAlias(array $alias = [])
		  {

				$this->alias = array_merge ($this->alias, $alias);

		  }

		  /**
			* Alias'ları döndürür
			* @return array
			*/
		  public function getAlias ()
		  {

				return $this->alias;

		  }

		  /**
			* Providersleri atar
			* @param $providers
			*/
		 public function  setProviders(array $providers)
		  {

				$this->providers = array_merge ($this->providers, $providers);

		  }

		  /**
			* Provider'sleri döndürür
			* @return array
			*/
		  public function getProviders ()
		  {
				return $this->providers;
		  }
	 }
