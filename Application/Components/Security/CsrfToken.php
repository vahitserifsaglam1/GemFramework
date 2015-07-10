<?php

    namespace Gem\Components\Security;

    use Gem\Components\Helpers\Server;
    use Gem\Components\Http\Input;
    use Gem\Components\Security\CsrfTokenCryptMethods\CsrfCryptMethod;

    /**
     * Bu Sınıf GemFramework'de CsrfToken oluşturma ve kontrol etme işlemleri için yapılmıştır
     * Class CsrfToken
     *
     * @package Gem\Components\Security
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     */
    class CsrfToken
    {
        use Server;
        private $cryptMethod;
        private $secretKey;
        private $formFieldName;

        /**
         * Başlatıcı fonksiyon
         */
        public function __construct()
        {
            $this->secretKey = $this->secretKeyGenerator();
        }

        /**
         * Anahtarı döndürür
         */
        public static function getKey()
        {
            retun(new static())->getSecretKey();
        }

        /**
         * @return string
         */
        public function getSecretKey()
        {
            return $this->secretKey;
        }

        /**
         * @param CsrfCryptMethod $method Metni şifreleyecek sınıfın objesi
         * @return $this
         */
        public function setCryptMethod(CsrfCryptMethod $method)
        {
            $this->cryptMethod = $method;

            return $this;
        }

        /**
         * Güvenli key oluşturur
         *
         * @return string
         */
        private function secretKeyGenerator()
        {
            $ip = $this->serverip;
            $len = strlen($ip);
            $letters = [];
            for ($i = 'a', $j = 1; $j <= 26; $i++, $j++) {

                $letters[$j] = $i;
            }
            $bas = substr($ip, 0, 2);
            $con = $letters[$len];
            $son = substr($ip, $len - 1, 1);
            $con2 = $letters[$len + $ip];

            return $son . FRAMEWORK_VERSION . $con . $con2 . $ip . $bas . FRAMEWORK_NAME;
        }

        /**
         * Formda aranacak isim
         *
         * @param string $name
         * @return $this
         */
        public function setFieldName($name = '')
        {
            $this->formFieldName = $name;

            return $this;
        }

        /**
         * Yürütme işlemini yapar
         *
         * @return bool
         * @throws CsrfTokenMatchException
         */
        public function run()
        {
            if (session()->has($this->formFieldName)) {
                $this->check();
            } else {
                return false;
            }
        }

        /**
         * Tokenin girilip girilmediğine bakar
         *
         * @return bool
         * @throws CsrfTokenMatchException
         */

        private function check()
        {
            if (Input::has($this->formFieldName)) {
                $key = Input::get($this->formFieldName);
                if ($key === session($this->formFieldName)) {
                    return true;
                } else {
                    throw new CsrfTokenMatchException(sprintf('Girdiğiniz %s token olması gereken tokenle eşleşmiyor',
                       $key));
                }
            } else {
                throw new CsrfTokenMatchException(sprintf('Herhangi bir Token Girişi yapmamışsınız'));
            }
        }
    }
