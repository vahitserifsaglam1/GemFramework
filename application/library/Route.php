<?php
/**
 *  Bu sýnýf Gem Framework un Route iþlemlerini gerçekleþtirir
 * 
 *  @package Gem\Components
 *  
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 * 
 */
 

 namespace Gem\Components;
 
 use Gem\Components\Helpers\String\Parser;
 use Gem\Components\Helpers\String\Builder;
 use Gem\Components\Helpers\Server;
 use Gem\Components\Helpers\Config;
 use Gem\Components\Helpers\Make\Controller;
 use Exception;
 
 class Route
 {
 	
 	use 
 	Parser,
 	Server,
 	Config,
 	Controller,
 	Builder;
 	
 	/**
 	 * 
 	 * @var $collection,$params,$types
 	 * @access private
 	 * 
 	 */
 	
 	private 
 	 $collection = [
 	 		
 	 ],
 	 $params = [],
 	 $filters = [],
 	 $basePath = '',
 	 $namedRoutes = [],
 	 $types = [
 			'get','delete','post','put'
 	];
 	
 	public function __construct()
 	{
 		
 		$this->basePath = $this->getConfig('configs')['url'];
 		
 		
 	}
 	
 	public function getTypes()
 	{
 		
 		return $this->types;
 		
 	}
 	
 	/**
 	 * 
 	 * @param string $type
 	 * @param array $args
 	 * @access public
 	 */
 	public function add($type, $args )
 	{
 		
 		$this->collection[$type][] = [
 				'action' => ltrim($args[0],'/'),
 				'callback' => $args[1]
 		];
 		
 	}
 	
 	/**
 	 * 
 	 * @param array $types
 	 * @param array $args
 	 * @access public
 	 * 
 	 */
 	
 	public function match($types, $args)
 	{
 		
 		foreach($types as $type){
 			
 			$this->add($type, $args);
 			
 		}
 		
 	}
 	
 	/**
 	 * Collectionlarý döndürür
 	 * @return Ambigous <multitype: boolean, multitype:array >
 	 * @access public
 	 */
 	
 	public function getCollections()
 	{
 		
 		return $this->collection;
 		
 	}
 	
 	/**
 	 * Http Methodunu Döndürür
 	 * @return string
 	 */
 	
 	public function getMethod()
 	{
 		
 		return mb_convert_case($this->get('REQUEST_METHOD'),MB_CASE_LOWER);
 		
 	}
 	
 	/**
 	 * Filter eklemesi yapar
 	 * @param string $name
 	 * @param string $pattern
 	 * @return null
 	 */
 	
 	public function filter($name = '', $pattern = '')
 	{
 		
 		$this->filters[$name] = $pattern;
 	   
 		
 	}
 	
 	/**
 	 * Filter i döndürür
 	 * @param string $name
 	 * @return boolean|string
 	 */
 	
 	public function getFilter($name)
 	{
 		
 	   return $a = $this->filters[$name] ?: false;
 		
 	}
 	
 	/**
 	 * Regex i döndürür
 	 * @return mixed
 	 */
 	
 	private function getRegex()
 	{
 		
 		return  preg_replace_callback("/:(\w+)/", [&$this, 'substituteFilter'], $this->getUrl());
 		
 	}
 	
 	/**
 	 * 
 	 * @param array $matches
 	 * @return string
 	 */
 	
 	private function substituteFilter(array $matches = [])
 	{

 		return $a = $this->getFilter($matches[1]) ?: "([\w-%]+)";
 		
 	}
 	
 	/**
 	 * 
 	 * Parametreleri atar
 	 * @param array $params
 	 * 
 	 */
 	
 	private function setParams( array $params = [] )
 	{
 		
 		$this->params = $params;
 		
 	}
 	
 	/**
 	 * Parametreleri döndürür
 	 * @return array
 	 */
 	
 	private function getParams()
 	{
 		
 		return $this->params;
 		
 	}
 	

 	public function setCollections(array $collections = [])
 	{
 		
 		$this->collection = $collections;
 		
 	}
 	
 	public function run()
 	{
 		
 		if(isset($this->getCollections()[$this->getMethod()]))
 			$collections = $this->getCollections()[$this->getMethod()];
 	
 		## kontrol ediliyor
 		if(count($collections) > 0)
 		{
 			
 		
 			// döngüye sokuyoruz
 			
 			foreach($collections as $collection)
 			{
 			
 			
 				
 				
 				if (! preg_match("@^".$this->getRegex()."*$@i", $this->getUrl(), $matches)) {
 					continue;
 				}
 				
 				
 				## parametreler
 				$params = [];
 				

 			
 			    $argument_keys = $this->createArgumentKeys($collection['action']);
 			
 			 
 				
 			    if( count($argument_keys) > 0 )
 				{

 	
 		
 					foreach($argument_keys as $key => $value)
 					{
 						
 			          
 						$matches =  $this->urlParser($this->getUrl());
 						
 						if (isset($matches[$key]))
 					    {
 						
 							$params[$value] = $matches[$key];
 							
 						}
 					
 					
 						
 					}
 					
 					$this->setParams($params);
 					
 					
 				}
 				
 				$url = $this->getUrl();
 				
 				if($url == '/')
 				{
 					
 					$url = '';
 				}
 				
 				## url in tamamý
 				$url = $this->basePath.$url;
  				
 				## oluþturulmuþ string
 				$replaced =  $this->basePath.
 				$this->replaceString($argument_keys,$params,$collection['action']
 				);

 			    
 				
 				if($url === $replaced )
 				{
 					
 					$this->dispatch($collection['callback']);
 					
 				}
 				
 				
 				
 			}
 			
 			
 			
 		}
 		else 
 		{
 			
 			return false;
 			
 		}
 		
 	}
 	
 	/**
 	 * Args larý hazýrlar
 	 * @param string $action
 	 * @return multitype:|unknown
 	 */
 	private function createArgumentKeys($action)
 	{
 		
 		return array_filter(
 			    		$this->urlParser($action),
 			    		function ($a){
 			    	
 			    			if(preg_match("/:([\w-%]+)/",  $a, $find))
 			    			{

 			  
 			    				return $find[1];
 			    				
 			    			}
 			    			
 			    		}
 			    );
 		
 	}
 	
 	/**
 	 * Callback parçalama iþlemi burada gerçekleþir
 	 * @param array $callback
 	 */
 	
 	private function dispatch($callback = [])
 	{
 		
 		
 		if( is_array($callback) )
 		{
 			
 			return $this->dispatchArray($callback);
 			
 		}
 		elseif(is_callable($callback))
 		{
 			
 			return $this->dispatchCallable($callback);
 			
 		}
 		elseif(is_string($callback))
 		{
 			
 		  return $this->dispatchString($callback);
 			
 		}
 		
 		
 		
 	}
 	
 	/**
 	 * 
 	 * @param array $callback
 	 */
 	private function dispatchArray(array $callback )
 	{
 	
 		
 		if(isset($callback['action']))
 		  $call =  $this->dispatch($callback['action']);
 		else 
 		  throw new Exception(sprintf("%s route olayýnýzda iþlenecek bir olay yok", $callback['action']));

 		if(isset($callback['name']))
 			$this->namedRoutes[$callback['name']] = $call;
 		
 	}
 	
 	/**
 	 * Çaðrýlabilir fonksiyonu yürütür
 	 * @param callable $callback
 	 * @return mixed
 	 */
 	private function dispatchCallable(callable $callback)
 	{
 		
 		$params = $this->getParams();
 		
 		return call_user_func_array($callback, $params);
 		
 		
 	}
 	
 	/**
 	 * Controller ý yürütür
 	 * @param string $callback
 	 */
 	
 	private function dispatchString($callback = '')
 	{
 		
 		if(strstr($callback,'::'))
 		{
 			
 			list($controller, $method) = $this->parseFromExploder($callback, '::');
 		    
 			
 		}
 		else
 		{
 			
 			$controller = $callback;
 			$method = '';
 			
 		}
 		
 		return $this->dispatchRunController($controller, $method);
 		
 	}
 	
 	/**
 	 * 
 	 * @param string $controller
 	 * @param string $method
 	 * 
 	 */
 	
 	private function dispatchRunController($controllerName, $method = '')
 	{
 		$controller = $this->makeController($controllerName);
 		
 		if($controller)
 		{
 			
 			if($method !== '')
 			{
 			
 			
 				if(is_callable([$controller,$method]))
 				{
 					
 					return call_user_func_array([$controller,$method], $this->getParams());
 					
 				}
 				else 
 				{
 					
 					throw new Exception(sprintf("%s cagrilabilir bir fonksiyon degil",$method));
 					
 				}
 			
 			
 			}
 			
 			return $controller;
 				
 			
 		}
 		else 
 		{
 			
 			throw new Exception(sprintf("%s kontrolleri yok, kontrol ediniz",$controllerName));
 			
 		}

 		
 		
 		
 		
 	}
 	
 	
 }