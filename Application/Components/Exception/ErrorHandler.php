<?php
    /**
     * Created by PhpStorm.
     * User: mrrobot
     * Date: 14.07.2015
     * Time: 11:50
     */

    namespace Gem\Components\Exception;

    use Gem\Components\Helpers\Config;
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
         * @return bool
         */
        public function handleError($errno, $errstr, $errfile, $errline)
        {

            if ($callback = Config::has('app.log.error')) {
                $callback($errno, $errstr, $errfile, $errline);
            }

            switch ($errno) {
                case E_USER_ERROR:
                    throw new GemCustomException($errstr, $errno, $errfile, $errline);
                    break;

                default:
                    return false;
                    break;
            }
        }

    }