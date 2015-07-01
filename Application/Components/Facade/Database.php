<?php
	 /**
	  * Created by PhpStorm.
	  * User: vserifsaglam
	  * Date: 23.6.2015
	  * Time: 03:25
	  */

	 namespace Gem\Components\Facade;

	 use Gem\Components\Patterns\Facade;
	 use Gem\Components\Patterns\Singleton;


	 class Database extends Facade
	 {

		  protected static function getFacadeClass ()
		  {

				return Singleton::make ('Gem\Components\Database\Base');

		  }

	 }
