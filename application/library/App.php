<?php
/**
 * 
 *   GemFramework dosyalarda Controller ve Model leri çaðýrmakta kullanýlacak
 *   
 *   @package Gem\Components
 *   
 *   @author vahitserifsaglam <vahit.serif119@gmail.com>
 *   
 *   @copyright MyfcYazilim
 *   
 * 
 */
namespace Gem\Components;

use Gem\Components\Helpers\Config;

class App
{
	
	const CONTROLLER = 'Controller';
	
	const MODEL = 'Model';
	
	const VIEW = 'View';
	
	/**
	 * Controller, method yada bir sýnýf çaðýrýr
	 * @param mixed $names
	 * @param string $type
	 * @return mixed
	 * @access public
	 */
	
	public static function uses($names, $type)
	{
		
		
	      switch ($type)
	      {
	      	
	      	case self::CONTROLLER:
	      		
	      		$this->includeController($names);
	      		
	      		break;
	      		
	      	case self::MODEL:
	      		
	      		$this->includeModel($names);
	      		
	      		break;
	      		
	      	case self::VIEW:
	      		
	      		$this->includeView($names);
	      		
	      		break;
	      	
	      }
		
		
	}
	
	/**
	 * Html da kullanýlmak için base kodunu oluþturur
	 * @return string
	 */
	 
	public static function base()
	{
		$config = self::getConfigStatic('configs')['url'];
		
		return '<base href="'.$config.'" target="_blank">';
	}

	
	
}