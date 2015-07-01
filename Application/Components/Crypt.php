<?php

	 /**
	  *
	  *  GemFramework Crypte sınıfı, şifrelenmiş metinler üretmek için kullanılır
	  * @package Gem\Components
	  * @author vahitserifsaglam <vahit.serif119@gmail.com>
	  *
	  */

	 namespace Gem\Components;

	 use Exception;
	 use Gem\Components\Helpers\Server;

	 class Crypt
	 {

		  use Server;
		  private $securityKey;
		  private $mode = MCRYPT_MODE_ECB;
		  private $rand = MCRYPT_RAND;
		  private $alogirtym = MCRYPT_RIJNDAEL_256;

		  public function __construct ()
		  {

				if ( !function_exists ('mcrypt_create_iv') ) {

					 throw new Exception('sunucunuzda mcrypt desteÄŸi bulunamadÄ±');
				}

				$this->securityKeyCreator ();
		  }

		  /**
			* GÃ¼venlik anahtarÄ± oluÅŸtrucu
			*/
		  private function securityKeyCreator ()
		  {

				$url = $this->findBasePath ();
				$ip = $this->serverip;
				$len = strlen ($ip);
				$letters = [ ];
				for ( $i = 'a', $j = 1; $j <= 26; $i++, $j++ ) {

					 $letters[ $j ] = $i;
				}
				$bas = substr ($ip, 0, 2);
				$con = $letters[ $len ];
				$son = substr ($ip, $len - 1, 1);
				$con2 = $letters[ $len + $ip ];
				$key = $url . $son . FRAMEWORK_VERSION . $con . $con2 . $ip . $bas . FRAMEWORK_NAME;
				$this->securityKey = md5 ($key);
		  }

		  /**
			* Şifrelenmiş metni oluşturur
			* @param string $value
			* @return string
			* @return mixed
			*/
		  public function encode ($value = '')
		  {

				if ( is_string ($value) ) {

					 $iv = mcrypt_create_iv ($this->getIvSize (), $this->getRandomizer ());

					 $base = base64_encode (json_encode ($this->payloadCreator ($this->encrypt ($value, $iv), $iv)));


					 return $base;
				}
		  }

		  /**
			* @param string $value
			* @param $iv
			* @return string
			*
			* Şifrelenmiş metni hazırlar
			*/
		  private function encrypt ($value = '', $iv)
		  {

				$value = $this->returnCleanAndHexedValue ($value);

				try {
					 $crypted = mcrypt_encrypt ($this->alogirtym, $this->securityKey, $value, $this->mode, $iv);

					 return $crypted;
				} catch ( Exception $e ) {
					 //
				}

		  }

		  /**
			* Value ve iv değerlerini kullanılmak için hazırlar
			* @param $creypted
			* @param $iv
			* @return array
			*/

		  private function payloadCreator ($creypted, $iv)
		  {


				return [
					 'value' => base64_encode ($creypted),
					 'iv'    => base64_encode ($iv),
				];
		  }

		  /**
			* Temizlenmiş value değeri oluşturur
			* @param string $value
			* @return string
			*/
		  private function returnCleanAndHexedValue ($value = '')
		  {

				$value = trim ($value);

				return $value;
		  }


		  /**
			* Randomizer i dÃ¶ndÃ¼rÃ¼r
			* @return int
			*/
		  private function getRandomizer ()
		  {

				if ( $this->rand ) {

					 return $this->rand;
				}
		  }

		  /**
			* Iv uzunluÄŸunu DÃ¶ndÃ¼rÃ¼r
			* @return int
			*/
		  private function getIvSize ()
		  {

				return mcrypt_get_iv_size ($this->alogirtym, $this->mode);
		  }

		  public function decode ($value = '')
		  {


				if ( is_string ($value) ) {

					 $payload = $this->parsePayload ($value);

					 return $this->decrypt ($payload);
				}
		  }

		  /**
			* @param $value
			* @return array
			*
			* payload verisi parçalanır
			*/
		  private function parsePayload ($value)
		  {

				$based = (array)json_decode (base64_decode ($value));


				if ( isset( $based['value'] ) && isset( $based['iv'] ) ) {


					 return [
						  'value' => base64_decode ($based['value']),
						  'iv'    => base64_decode ($based['iv'])
					 ];
				}
		  }

		  /**
			* Metnin şifresini çözer
			* @param array $payload
			* @return string
			*/
		  private function decrypt (array $payload)
		  {


				$iv = $payload['iv'];

				$value = $payload['value'];

				$value = $this->returnCleanAndDeHexedValue ($value);

				return mcrypt_decrypt ($this->alogirtym, $this->securityKey, $value, $this->mode, $iv);
		  }

		  /**
			* @param $value
			* @return string
			* Parametreyi temizler ve hexden çıkarır
			*/
		  private function returnCleanAndDeHexedValue ($value)
		  {

				$value = trim ($value);


				return $value;
		  }

		  /**
			* @param $value
			* @return string
			* Parametreyi hex halinden kurtarÄ±r
			*/

	 }
