<?php
    /**
     *  Bu Provider İle error ve exception tanımlamarı yapılır
     */
    namespace Gem\Manager\Providers;

    use Gem\Components\Exception\ErrorHandler;
    use Gem\Components\Exception\ExceptionHandler;
    use Gem\Components\Helpers\Config;

    /**
     * Class ErrorProvider
     * @package Gem\Manager\Providers
     */
    class ErrorProvider
    {

        /**
         * Hataları yakalar
         */
        public function __construct()
        {
            ini_set('display_errors', 'On');
            error_reporting(E_ALL);
            set_exception_handler(Config::getConfigStatic('app.exception.handler'));
            set_error_handler(Config::getConfigStatic('app.error.handler'));
        }

    }