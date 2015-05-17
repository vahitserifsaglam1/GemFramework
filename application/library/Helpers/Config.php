<?php
/**
 * GemFramework Config Helper -> kullanýcý ayarlarýnýnýn çekildiði trait
 *  
 * @package Gem\Components\Helpers
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * 
 */

namespace Gem\Components\Helpers;


trait Config
{
		
	/**
	 * Ýstenilen ayarý getirir
	 * @param string $config
	 * @return boolean|mixed
	 * @access public
	 * 
	 */
	
	public function getConfig($config = ''){
		
		$path = CONFIG_PATH.$config.'.php';
		
		if(file_exists($path))
		{
			
			return include $path;
			
		}
		else
		{
			
			return false;
			
		}
		
	}
	
    /**
	 * Ýstenilen ayarý getirir
	 * @param string $config
	 * @return boolean|mixed
	 * @access public
	 * 
	 */
	
	public static function getConfigStatic($config)
	{
		$path = CONFIG_PATH.$config.'.php';
		
		if(file_exists($path))
		{
			
			return include $path;
			
		}
		else
		{
			
			return false;
			
		}
		
	}
	
	
}