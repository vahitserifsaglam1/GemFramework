<?php
	 /**
	  *
	  * Bu Sınıf GemFrameworkde cookie işlemleri yapmakta kullanılır
	  * @author vahitserifsaglam <vahit.serif119@gmail.com>
	  *
	  */

	 namespace Gem\Components\Http;

	 use DateTime;
	 use InvalidArgumentException;

	 /**
	  * Class CookieBar
	  * @package Gem\Components\Http
	  */
	 class CookieJar
	 {

		  private $value;
		  private $name;
		  private $expires;
		  private $domain;
		  private $secure;
		  private $httpOnly;
		  private $path;

		  /**
			* Bu fonksiyon Cookie parametreleri'ni sınıfa atar.
			*
			* @param string $name
			* @param string $value
			* @param int $expires
			* @param string $path
			* @param null $domain
			* @param bool $secure
			* @param bool $httpOnly
			*/
		  public function __construct ($name = '', $value = '', $expires = 3600, $path = '/', $domain = null, $secure = false, $httpOnly = false)
		  {

				if ( preg_match ("/[=,; \t\r\n\013\014]/", $name) ) {
					 throw new InvalidArgumentException(sprintf ('Girdiğiniz %s ismi geçersiz karekterler içermektedir.', $name));
				}

				if ( empty( $name ) ) {
					 throw new InvalidArgumentException('İsim değeriniz boş olamaz');
				}

				if ( $expires instanceof DateTime ) {
					 $expires = $expires->format ('U');
				} elseif ( is_string ($expires) ) {
					 $expires = strtotime ($expires);
					 if ( false === $expires || -1 === $expires ) {
						  throw new InvalidArgumentException('Cookie e girmiş olduğunuz geçerlilik süresi yanlış.');
					 }
				}

				$this->name = $name;
				$this->value = $value;
				$this->expires = $expires;
				$this->path = $path;
				$this->domain = $domain;
				$this->secure = (bool)$secure;
				$this->httpOnly = (bool)$httpOnly;


		  }

		  /**
			* Cookie metnini oluşturur
			* @return string
			*/
		  public function __toString ()
		  {

				$cookie = urlencode ($this->name) . '=';

				if ( '' === $this->value ) {
					 $cookie .= 'deleted; expires=' . date ('D, d-M-Y H:i:s T', 0);
				} else {

					 $cookie .= urlencode ($this->value);
					 if ( 0 !== $this->expires ) {

						  $cookie .= '; expires=' . gmdate ('D, d-M-Y H:i:s T', time () + $this->expires);

					 }

				}

				if ( $this->path ) {
					 $cookie .= '; path=' . $this->path;
				}

				if ( $this->domain ) {
					 $cookie .= '; domain=' . $this->domain;
				}

				if ( true === $this->secure ) {
					 $cookie .= '; secure';
				}

				if ( true === $this->httpOnly ) {

					 $cookie .= '; httponly';

				}
				return $cookie;
		  }

		  /**
			* Static olarak instance oluşturmak
			* @param string $name
			* @param string $value
			* @param int $expires
			* @param string $path
			* @param null $domain
			* @param bool $secure
			* @param bool $httpOnly
			* @return static
			*/
		  public static function make ($name = '', $value = '', $expires = 0, $path = '/', $domain = null, $secure = false, $httpOnly = false)
		  {

				return new self($name, $value, $expires, $path, $domain, $secure, $httpOnly);

		  }

	 }
