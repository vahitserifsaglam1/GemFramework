<?php

	 /**
	  *
	  *  Bu s�n�f GemFramework de route ve database s�n�f�na yard�mc�
	  *  olmak �zere baz� fonksiyonlar� bar�nd�r�r
	  *
	  * @package Gem\Components\Helpers\String
	  * @author vahitserifsaglam <vahit.serif119@gmail.com>
	  */

	 namespace Gem\Components\Helpers\String;

	 /**
	  *
	  * @trait Parser
	  *
	  */
	 trait Parser
	 {

		  /**
			*
			* Url par�alamada kullan�l�r
			* @param string $url
			* @return multitype:array
			* @access public
			*
			*/
		  function urlParser ($url)
		  {


				return $this->parseFromExploder ($url, '/');
		  }

		  /**
			* Bir par�alay�c� yard�m�yla verileri par�alar
			* @param string $string
			* @param string $parser
			* @return multitype:array
			* @access public
			*
			*/
		  function parseFromExploder ($string, $parser = '')
		  {

				$string = trim ($string, $parser);

				return explode ($parser, $string);
		  }

		  /**
			* . lar� par�alar
			* @param unknown $string
			* @return Ambigous <multitype:multitype: , multitype:>
			* @access public
			*
			*/
		  function dotParser ($string)
		  {

				return $this->parseFromExploder ($string, '.');
		  }

		  /**
			* Girilen preg_match de�erine g�re uyumlu olup olmad���na bakar
			* @param array $parsed
			* @param string $preg
			* @return array
			* @access public
			*
			*/
		  function matchStringFromParsed (array $parsed = [ ], $implodeWith = '', $preg = '')
		  {

				$content = implode ($implodeWith, $parsed);

				foreach ( $parsed as $parse ) {

					 if ( $preg = preg_match ($preg, $parse, $find) ) {

						  $start = strpos ($find[1], $content);
						  $lenght = strlen ($find[1]);
						  $return = [ ];
						  $return[] = [ $parse => [

								'finded' => $find,
								'find'   => $find[1],
								'start'  => $start,
								'lenght' => $lenght,
								'end'    => $start + $lenght
						  ] ];
					 }
				}

				return $return;
		  }

	 }
