<?php

    namespace Gem\Components\Support;
    trait SecurityKey
    {

        /**
         * Yeni bir key oluşturur
         * @return string
         */
        protected function keyGenerate()
        {

            $ip = $_SERVER['REMOTE_ADDR'];
            $len = strlen($ip);
            $letters = [];
            for ($i = 'a', $j = 1; $j <= 26; $i++, $j++) {

                $letters[$j] = $i;
            }
            $bas = substr($ip, 0, 2);
            $con = $letters[$len];
            $son = substr($ip, $len - 1, 1);
            $con2 = $letters[$len + $ip];
            $key = $son . FRAMEWORK_VERSION . $con . $con2 . $ip . $bas . FRAMEWORK_NAME;
            return md5($key);
        }

    }