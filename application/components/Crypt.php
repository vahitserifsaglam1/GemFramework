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

    public function __construct()
    {

        if (!function_exists('mcrypt_create_iv')) {

            throw new Exception('sunucunuzda mcrypt desteÄŸi bulunamadÄ±');
        }

        $this->securityKeyCreator();
    }

    /**
     * GÃ¼venlik anahtarÄ± oluÅŸtrucu
     */
    private function securityKeyCreator()
    {

        $url = $this->findBasePath();
        $ip = $this->getIP();
        $len = strlen($ip);
        $letters = [];
        for ($i = 'a', $j = 1; $j <= 26; $i++, $j++) {

            $letters[$j] = $i;
        }
        $bas = substr($ip, 0, 2);
        $con = $letters[$len];
        $son = substr($ip, $len - 1, 1);
        $con2 = $letters[$len + $ip];
        $key = $url . $con . $con2 . $ip . $bas;
        $this->securityKey = md5($key);
    }

    /**
     * Å�ifrelenmiÅŸ Metin oluÅŸturur
     * @param string $value
     * @return string
     */
    public function encode($value = '')
    {

        if (is_string($value)) {

            $iv = mcrypt_create_iv($this->getIvSize(), $this->getRandomizer());

            $base = base64_encode(json_encode($this->payloadCreator($this->encrypt($value, $iv), $iv)));


            return $base;
        }
    }

    /**
     * @param string $value
     * @param $iv
     * @return string
     *
     * Å�ifrelenmiÅŸ metin oluÅŸturur
     */
    private function encrypt($value = '', $iv)
    {

        $value = $this->returnCleanAndHexedValue($value);

        return @mcrypt_encrypt($this->alogirtym, $this->securityKey, $value, $this->mode, $iv);
    }

    private function payloadCreator($creypted, $iv)
    {


        return array(
            'value' => base64_encode($creypted),
            'iv' => base64_encode($iv),
        );
    }

    /**
     * TemizlenmiÅŸ ve hex e dÃ¶ndÃ¼rÃ¼lmÃ¼ÅŸ deÄŸer oluÅŸturur
     * @param string $value
     * @return string
     */
    private function returnCleanAndHexedValue($value = '')
    {

        $value = trim($value);
        return $value;
    }

    private function hexValue($value)
    {

        if (function_exists('bin2hex')) {

            return bin2hex($value);
        } else {

            return $value;
        }
    }

    /**
     * Randomizer i dÃ¶ndÃ¼rÃ¼r
     * @return int
     */
    private function getRandomizer()
    {

        if ($this->rand) {

            return $this->rand;
        }
    }

    /**
     * Iv uzunluÄŸunu DÃ¶ndÃ¼rÃ¼r
     * @return int
     */
    private function getIvSize()
    {

        return mcrypt_get_iv_size($this->alogirtym, $this->mode);
    }

    public function decode($value = '')
    {


        if (is_string($value)) {

            $payload = $this->parsePayload($value);

            return $this->decrypt($payload);
        }
    }

    /**
     * @param $value
     * @return array
     *
     * PayloadÄ± parÃ§alamakta kullanÄ±lÄ±r
     */
    private function parsePayload($value)
    {


        $based = (array)json_decode(base64_decode($value));


        if (isset($based['value']) && isset($based['iv'])) {


            return array(
                'value' => base64_decode($based['value']),
                'iv' => base64_decode($based['iv'])
            );
        }
    }

    /**
     * Metnin ÅŸireli halini Ã§Ã¶zer
     * @param array $payload
     * @return string
     */
    private function decrypt(array $payload)
    {


        $iv = $payload['iv'];

        $value = $payload['value'];

        $value = $this->returnCleanAndDeHexedValue($value);

        return mcrypt_decrypt($this->alogirtym, $this->securityKey, $value, $this->mode, $iv);
    }

    /**
     * @param $value
     * @return string
     * Parametreyi temizler ve hexden kurtarÄ±r
     */
    private function returnCleanAndDeHexedValue($value)
    {

        $value = trim($value);


        return $value;
    }

    /**
     * @param $value
     * @return string
     * Parametreyi hex halinden kurtarÄ±r
     */
    private function deHexValue($value)
    {


        if (function_exists('hex2bin')) {

            return hex2bin($value);
        }
    }

}
