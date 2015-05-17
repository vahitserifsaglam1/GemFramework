<?php

/**
 * 
 *  Modellerde extends edilecek sınıf, facede görevinde kullanılır
 *  
 *  @package Gem\Components\Database
 *  
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 *  
 *  @copyright MyfcYazilim
 * 
 */

namespace Gem\Components\Database;

use Gem\Components\Database\Base;
class Model
{
	
	private  $instance;
	
	
	public function __construct()
	{
		 
		 $this->instance = new Base();
		 
	}
	
	public static function __callStatic($name , $params)
	{
	
		$instance = new static();
	
		return call_user_func_array([$instance->instance,$name], $params);
	
	
	}
	
	
	
	
}
