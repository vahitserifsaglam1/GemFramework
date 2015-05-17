<?php
/**
 * 
 *  Bu sýnýf GemFramework de route ve database sýnýfýna yardýmcý
 *  olmak üzere bazý fonksiyonlarý barýndýrýr
 *  
 *  @package Gem\Components\Helpers\String
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 */

namespace  Gem\Components\Helpers\String;

/**
 *
 * @trait Parser
 *
 */

trait Parser
{
	
	
	/**
	 * 
	 * Url parçalamada kullanýlýr
	 * @param string $url
	 * @return multitype:array
	 * @access public
	 * 
	 */
	
	 function urlParser($url)
	 {
		
		
		return $this->parseFromExploder($url, '/');
		
	}
	
	/**
	 * Bir parçalayýcý yardýmýyla verileri parçalar 
	 * @param string $string
	 * @param string $parser
	 * @return multitype:array
	 * @access public
	 * 
	 */
	
	 function parseFromExploder($string, $parser = '')
	 {
		
		$string = trim($string,$parser);
		return explode($parser, $string);
		
	}
	
	/**
	 * . larý parçalar
	 * @param unknown $string
	 * @return Ambigous <multitype:multitype: , multitype:>
	 * @access public 
	 * 
	 */
	
	 function dotParser($string)
	 {
		
		return $this->parseFromExploder($string,'.');
		
	}
	
	/**
	 * Girilen preg_match deðerine göre uyumlu olup olmadýðýna bakar
	 * @param array $parsed
	 * @param string $preg
	 * @return array
	 * @access public
	 * 
	 */
	
	function matchStringFromParsed(array $parsed = [] ,$implodeWith = '', $preg = '')
	{
		
		$content = implode($implodeWith, $parsed);
		
		foreach($parsed as $parse){
			
			if($preg = preg_match($preg, $parse, $find)){
				
				$start = strpos($find[1], $content);
				$lenght = strlen($find[1]);
				yield $parse => [

						'finded' => $find,
						'find'   => $find[1],
						'start'  => $start,
						'lenght' => $lenght,
						'end'    => $start + $lenght
						 
				];
				
			}
			
		}
		
	}
	
}