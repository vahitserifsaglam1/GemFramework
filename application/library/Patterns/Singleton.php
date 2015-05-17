<?php
/**
 * Bu dosya GemFramework 'un Singleton Desing Pattern
 * Sýnýfýna ait bir dosyadýr, Singleton Pattern bu sýnýf üzerinden çalýþýr.
 * 
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @package Gem\Components\Patterns
 * @copyright MyfcYazýlým
 *  
 */

 namespace Gem\Components\Patterns;
 
 class Singleton{
 	
 	/**
 	 * 
 	 * @var Object, Integer
 	 * @access private
 	 * 
 	 * Sýnýflarýn instancelerini ve oluþan toplam sayýyý tutar
 	 * 
 	 */
 	private static $instances,
 	 $instances_count = 0;
 	
 	/**
 	 * Yeni bir instance oluþturur
 	 * @param mixed $instance
 	 * @param mixed ...$parametres
 	 * @access public
 	 * @return Object
 	 */
 	
 	static function make($instance, ...$parametres)
 	{
 		
 		
 		if(!is_object($instance))
 			 $instance_name =  $instance;
 		else 
 			$instance_name = get_class($instance);
 		
 	    if(!isset(self::$instances[$instance_name]))
 	    {
 	    	
 	    	self::$instances[$instance_name] = $instance;
 	    	
 	    }
 	    
 	    return self::$instances[$instance_name];
 		
 	}
 	
 
 	
 }
 
 