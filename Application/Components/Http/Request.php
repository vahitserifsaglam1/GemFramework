<?php
	 /**
	  *
	  * Bu sınıf GemFramework'un bir parçasıdır, Http ile ilgili bir çok işlem buradan gerçekleştirilir.
	  * @author vahitserifsaglam <vahit.serif119@gmail.com>
	  * @copyright (c) 2015,  MyfcYazilim
	  *
	  */
	 namespace Gem\Components\Http;

	 use Gem\Components\Helpers\Server;
	 use Gem\Components\Patterns\Singleton;
	 use Gem\Components\Redirect;
	 use Gem\Components\Session;

	 class Request extends ServerBag
	 {

		  use Server;

		  /**
			* Yönlendirme yapar, $time girilirse belirli bi süre bekletilir.
			* @param string $to
			* @param integer $time
			*/

		  public function redirect ($to, $time = null)
		  {

				Redirect::to ($to, $time);

		  }

		  /**
			* sessionda $name atandıysa onu döndürür
			* @param string $name
			* @return mixed
			*/
		  public function session ($name)
		  {

				if ( Session::has ($name) ) {

					 return Session::get ($name);

				}

		  }

         /**
          * Methodun aynı olup olmadığına bakar
          * @param string $method
          * @return bool
          */
         public function isMethod($method = '')
         {
             $method = mb_convert_case($method, MB_CASE_UPPER);
             if($this->getMethod() === $method)
             {
                 return true;
             }
         }

         /**
          * Url tetiklenip tetiklenmediğine bakılır
          * @param string $url
          * @return bool
          */
         public function is($url = '')
         {
             if(strstr($url, '*'))
             {
                 $url = str_replace('*','',$url);
             }

             if(strstr($this->getUrl(), $url))
             {
                 return true;
             }
         }
		  /**
			* input dan veri çekmekte kullanılır
			* @param null $name
            * @param null  $control
			* @return mixed
			*/
		  public function input ($name = null, $control = null)
		  {

				return input($name, $control);

		  }

		  /**
			* UserManager obejsi döndürür
			* @return UserManager
			*/

		  public function user ()
		  {

				return Singleton::make ('\Gem\Components\Http\UserManager', [ ]);

		  }

		  /**
			*
			* @return string
			*/
		  public function host ()
		  {

				return $this->host;

		  }

		  /**
			*
			* Kişiyi geldiği sayfaya döndürür
			* @return string
			*
			*/
		  public function back ()
		  {

				return $this->referer;

		  }

	 }
