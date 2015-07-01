<?php

	 namespace Gem\Components\Http;

	 use ErrorException;
	 use Gem\Components\Auth;
	 use Gem\Components\Redirect;
	 use Gem\Components\Session;

	 class UserManager
	 {


		  private $errorPage;
		  private $errorFile;

		  const LOGIN = 'GemLogin';

		  /**
			* Error tetiklendiğinde yönlendirilecek sayfa atanır
			* @param string $url
			* @return \Gem\Components\Http\UserManager
			*/
		  public function setErrorPage ($url)
		  {

				$this->errorPage = $url;

				return $this;

		  }

		  /**
			* Atanan error page veya error file ye göre işlem yapar
			* öncelik error page dedir, eğer atanmışsa o sayfaya yönlendirme yapılır,
			* eğer atanmamışsa error file include edilir
			* @return \Gem\Components\Http\UserManager
			*/

		  public function error ()
		  {

				if ( $this->errorPage ) {

					 Redirect::to ($this->errorPage);

				} elseif ( isset($this->errorFile) &&  true === file_exists($this->errorFile) ) {

					 include $this->errorFile;

				}


				return $this;

		  }


		  /**
			* girilen $path daki dosyayı içerik olarak alır
			* @param string $path
			* @return \Gem\Components\Http\UserManager
			* @throws ErrorException
			*/
		  public function setErrorFile ($path)
		  {

				if ( file_exists ($path) ) {

					 $this->errorFile = $path;

				} else {

					 throw new ErrorException(sprintf ('%s fonksiyonu parametre olarak girdiğiniz %s yolunda herhangi bir dosya bulunamadı', __FUNCTION__, $path));

				}

				return $this;

		  }

		  /**
			* Kullanıcı girişi yapılıp yapılmadığını kontrol eder
			* @param bool $remember Cookie Kontrolu' yapmakda kullanılır
			* @return boolean
			*/
		  public function isLogined ($remember = false)
		  {
				return Auth::check ($remember);
		  }

		  /**
			* Userin bu işi yapmaya yetkisi olup olmadığını kontrol eder
			* @param string $role
			* @return boolean
			*/
		  public function hasRole ($role)
		  {

				if ( !Session::has (self::LOGIN) )
					 return false;


				$get = Session::get (self::LOGIN)['role'];
				if ( strstr ($get, ",") ) {
					 $get = explode (',', $get);
				}
				if ( $get !== 'all' ) {
					 if ( array_search ($role, $get) ) {

						  return true;
					 }
				} else {

					 return true;
				}
		  }

	 }
