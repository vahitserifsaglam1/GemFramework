<?php

    namespace Gem\System;

    /**
     *
     * Bu Sayfada Sayfanın Kapanışıyla ilgili işlemler yapabilirsiniz
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    use Gem\Components\App;
    use Gem\Components\Exception\ErrorHandler;
    use Gem\Components\Http\Request;
    use Gem\Components\Log\Listen;
    use Gem\Components\Log\ExceptionLog;
    use Gem\Components\Log\ErrorLog;
    use Gem\Components\Exception\ExceptionHandler;
    use Exception;

    class SystemManager
    {

        public function __construct()
        {
            /**
             *   |  ****************
             *   |  Girilen url herhangi bir röta ile eşleşmiyorsa tetiklenecek işlem callable veya string girilebilir
             *   |  ****************
             */
            App::miss(function (Request $request) {
                response(view('404'))->execute();
            });

            /**
             *  İstisnaları dinlemeye alır
             */
            App::exception(function (Exception $exception) {
                $handle = new ExceptionHandler();
                $handle->handleException($exception);
            });

            /**
             * Hataları dinlemeye alır
             */
            App::error(function ($errno, $errstr, $errfile, $errline) {
                $handle = new ErrorHandler();
                $handle->handleError($errno, $errstr, $errfile, $errline);
            });

            /**
             * Exception ları log a atar
             */
            Listen::exception(function (Exception $exception) {
                new ExceptionLog($exception);
            });

            /**
             * Hataları log a atar
             */
            Listen::error(function ($errno, $errstr, $errfile, $errline) {
                new ErrorLog($errno, $errstr, $errfile, $errline);
            });


        }

    }



