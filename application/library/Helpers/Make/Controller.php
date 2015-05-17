<?php
/**
 * 
 *  GemFramework Controller Trait -> bu trait ile contoller instance i oluþturulur
 *   
 *  @package Gem\Components\Helpers\Make
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 */

 namespace Gem\Components\Helpers\Make;
 
 
 trait Controller{
 	
 	/**
 	 * Yeni bir kontroller instance oluþturur
 	 * @param string $controller
 	 * @return Ambigous <object, NULL>
 	 */
 	
 	
 	public function makeController($controller)
 	{
 		
 		$controllerName = $controller;
 		
 		$controllerPath = APP.'Controllers/'.$controllerName.'.php';
 		
 		if(file_exists($controllerPath))
 		{
 			
 			if(!class_exists($controller))
 			{
 				
 				include $controllerPath;
 				
 			}
 			
 		    $controller = new $controllerName;
 			
 		}
 		else 
 		{
 			
 			$controller = null;
 			
 		}
 		
 		return $controller;
 		
 	}
 	
 	
 }