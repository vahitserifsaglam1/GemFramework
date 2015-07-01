<?php

	 /**
	  *  Bu Sınıf GemFramework de Güvenli Oturum İşlemleri yapmak için yapılmıştır
	  * @author vahitserifsaglam <vahit.serif119@gmail.com>
	  */
	 namespace Gem\Components\Session;

	 use Exception;
	 use SessionHandler;

	 /**
	  * Class SessionHandler
	  * @package Gem\Components\Session
	  */
	 class SecureSessionHandler extends SessionHandler
	 {

		  private $name, $cookie;

		  /**
			* Güvenli Session işlemini başlatır
			* @param string $key
			* @param string $name
			* @param array $cookie
			* @throws Exception
			*/
		  public function __construct ($name = 'GEM_SESSION', array $cookie = [ ])
		  {
				$this->name = $name;
				$this->cookie = $cookie;

				$this->cookie += [
					 'lifetime' => 0,
					 'path'     => ini_get ('session.cookie_path'),
					 'domain'   => ini_get ('session.cookie_domain'),
					 'secure'   => isset( $_SERVER['HTTPS'] ),
					 'httponly' => true
				];

				$this->setup ();
				$this->start ();
		  }

		  /**
			* Session işlemini başlatır
			* @return bool
			*/
		  private function start ()
		  {
				if ( session_id () === '' ) {
					 if ( session_start () ) {
						  return ( mt_rand (0, 4) === 0 ) ? $this->refresh () : true; // 1/5
					 }
				}

				return false;
		  }


		  /**
			* Girilen Oturumu sıfırlar
			* @return bool
			*/
		  public function forget ()
		  {
				if ( session_id () === '' ) {
					 return false;
				}

				$_SESSION = [ ];

				setcookie (
					 $this->name, '', time () - 42000,
					 $this->cookie['path'], $this->cookie['domain'],
					 $this->cookie['secure'], $this->cookie['httponly']
				);

				return session_destroy ();
		  }

		  /**
			* Oturumu yeniden başlatır
			* @return bool
			*/
		  private function refresh ()
		  {
				return session_regenerate_id (true);
		  }


		  /**
			*  Kurulumu yapar
			*/
		  private function setup ()
		  {

				ini_set ('session.use_cookies', 1);
				ini_set ('session.use_only_cookies', 1);

				session_name ($this->name);

				session_set_cookie_params (
					 $this->cookie['lifetime'], $this->cookie['path'],
					 $this->cookie['domain'], $this->cookie['secure'],
					 $this->cookie['httponly']
				);

				ini_set ('session.save_handler', 'files');
				session_set_save_handler ($this, true);
		  }

		  /**
			* Oturumun sona erip ermediğine bakar
			* @param int $ttl
			* @return bool
			*/
		  public function isExpired ($ttl = 30)
		  {
				$activity = isset( $_SESSION['_last_activity'] )
					 ? $_SESSION['_last_activity']
					 : false;

				if ( $activity !== false && time () - $activity > $ttl * 60 ) {
					 return true;
				}

				$_SESSION['_last_activity'] = time ();

				return false;
		  }

		  /**
			* Kullanıcı parmak izi bırakmışmı kontrol eder
			* @return bool
			*/
		  public function isFingerprint ()
		  {
				$hash = md5 (
					 $this->useragent .
					 ( ip2long ($_SERVER['REMOTE_ADDR']) & ip2long ('255.255.0.0') )
				);

				if ( isset( $_SESSION['_fingerprint'] ) ) {
					 return $_SESSION['_fingerprint'] === $hash;
				}

				$_SESSION['_fingerprint'] = $hash;

				return true;
		  }

		  /**
			* Oturumun geçerli bir oturum olup olmadığına bakar
			* @param int $ttl
			* @return bool
			*/
		  public function isValid ($ttl = 30)
		  {
				return !$this->isExpired ($ttl) && $this->isFingerprint ();
		  }

		  /**
			* @param string $name Oturum değerinin ismi
			* @return mixed
			*/
		  protected function getValue ($name = '')
		  {
				$parsed = explode ('.', $name);

				$result = $_SESSION;

				while ( $parsed ) {
					 $next = array_shift ($parsed);

					 if ( isset( $result[ $next ] ) ) {
						  $result = $result[ $next ];
					 } else {
						  return null;
					 }
				}


				return $result;
		  }

		  /**
			* @param string $name Girilecek oturumun ismi
			* @param string $value Girilecek oturumun değeri
			*/
		  protected function setValue ($name, $value)
		  {
				$parsed = explode ('.', $name);

				$session =& $_SESSION;

				while ( count ($parsed) > 1 ) {
					 $next = array_shift ($parsed);

					 if ( !isset( $session[ $next ] ) || !is_array ($session[ $next ]) ) {
						  $session[ $next ] = [ ];
					 }

					 $session =& $session[ $next ];
				}

				$session[ array_shift ($parsed) ] = $value;
		  }
	 }
