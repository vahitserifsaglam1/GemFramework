<?php
	 /**
	  * Created by PhpStorm.
	  * User: vserifsaglam
	  * Date: 24.6.2015
	  * Time: 02:03
	  */

	 namespace Gem\Components;


	 class Security
	 {

		  public static function xssProtection ($data = '')
		  {

				$data = str_replace ([ '"', "'", "<", ">", "&lt;" ], '', $data);
				if ( !is_string ($data) ) {

					 throw new \Exception(sprintf ('%s veri tipi %s fonksiyonunda kullanılamaz', gettype ($data), __FUNCTION__));

				}

				$data = strip_tags (
					 htmlspecialchars (
						  htmlentities (
								filter_var ($data, FILTER_SANITIZE_SPECIAL_CHARS))
					 )
				);

				return $data;

		  }

		  /**
			* Epostanın geçerli olup olmadığına bakar
			* @param string $mail
			* @return mixed
			*/
		  public static function validateEmail ($mail = '')
		  {

				return filter_var ($mail, FILTER_VALIDATE_EMAIL);

		  }

		  /**
			* Url i kontrol eder
			* @param string $url
			* @return mixed
			*/
		  public static function validateUrl ($url = '')
		  {

				return filter_var ($url, FILTER_VALIDATE_URL);

		  }

	 }
