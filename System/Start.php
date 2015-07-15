<?php


    /**
     *
     * Bu Sayfada Sayfanın Kapanışıyla ilgili işlemler yapabilirsiniz
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    use Gem\Components\App;
    use Gem\Components\Http\Request;


    /**
     *   |  ****************
     *   |  Girilen url herhangi bir röta ile eşleşmiyorsa tetiklenecek işlem callable veya string girilebilir
     *   |  ****************
     */
    App::miss(function (Request $request) {
        $request->redirect('404');
    });

    /**
     *  İstisnaları dinlemeye alır
     */
    App::exception(function (Exception $exception) {
        $handle = new \Gem\Components\Exception\ExceptionHandler();
        $handle->handleException($exception);
    });

    /**
     * Hataları dinlemeye alır
     */
    App::error(function ($errno, $errstr, $errfile, $errline) {
        $handle = new \Gem\Components\Exception\ErrorHandler();
        $handle->handleError($errno, $errstr, $errfile, $errline);
    });



