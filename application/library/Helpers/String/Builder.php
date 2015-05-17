<?php
/**
 * 
 *  GemFramework String Builder Trait -> metinleri birleþtirirken
 *  kullanýlacak bazý fonksiyonlarý içerir
 *  
 *  @package Gem\Components\Helpers\String
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 *  @version 1.0
 * 
 */

 namespace Gem\Components\Helpers\String;
 
 
 trait Builder
 {
 	
 	/**
 	 * Verilen diziyi bir string haline getirir
 	 * @param array $array
 	 * @param string $joiner
 	 * @return string
 	 * @access public
 	 * 
 	 */
 	 public function joinWithImploder(array $array = [], $joiner )
 	 {
 	 	
 	 	return join($joiner, $array);
 	 	
 	 	
 	 }
 	 
 	 /**
 	  * . lý metni / e çevirir
 	  * @param unknown $dot
 	  * @return string
 	  */
 	 public  function joinDotToUrl($dot)
 	 {
 	 	
 	 	return $this->replaceString(".", "/", $dot);
 	 	
 	 }
 	 
 	 /**
 	  * Url linki oluþturur
 	  * @param array $url
 	  * @return string
 	  */
 	 
 	 public function joinUrl(array $url = [])
 	 {
 	 	
 	 	return $this->joinWithImploder($url, '/');
 	 	
 	 }
 	 
 	 /**
 	  * . yapýsýnda bir veri oluþturur
 	  * @param array $dor
 	  * @return string
 	  */
 	 public function joinWithDot(array $dor = [])
 	 {
 	 	
 	 	return $this->joinWithImploder($dot,'.');
 	 	
 	 }
 	 
 	 /**
 	  * 
 	  * @param mixed $search
 	  * @param mixed $replace
 	  * @param string $string
 	  * @return string
 	  * @access public
 	  */
 	 
 	 public function replaceString($search, $replace, $string)
 	 {
 	 	
 	 	return str_replace($search, $replace, $string);
 	 	
 	 }
 	 
 	 
 	
 }