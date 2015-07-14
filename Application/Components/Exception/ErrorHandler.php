<?php
    /**
     * Created by PhpStorm.
     * User: mrrobot
     * Date: 14.07.2015
     * Time: 11:50
     */

    namespace Gem\Components\Exception;

    use Gem\Components\Exception\GemCustomException;

    class ErrorHandler
    {

        /**
         *
         * Hataları yakalar
         * @param $errno
         * @param $errstr
         * @param $errfile
         * @param $errline
         * @throws GemCustomException
         */
        public function handleError($errno, $errstr, $errfile, $errline)
        {

            switch ($errno) {
                case E_USER_ERROR:
                    throw new GemCustomException($errstr, $errno, $errfile, $errline);
                case E_USER_WARNING:
                    printf('<b>Uyarı</b>: %s dosyasında, %s satırında, %s hata mesajı oluştu', $errfile, $errline,
                        $errstr);
                    break;

                case E_USER_NOTICE:
                    printf('<b>Dikkat</b>, Bİlgi: %s dosyasında, %s satırında, %s hata mesajı oluştu', $errfile,
                        $errline,
                        $errstr);
                    break;

                default:
                    printf('<b/>Bilinmeyen bir hata</b>: %s dosyasında, %s satırında, %s hata mesajı oluştu', $errfile,
                        $errline, $errstr);
                    break;
            }
        }

    }