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
        use Config;
        /**
         * Hataları yakalar
         */
        public function __construct()
        {

            set_exception_handler(static::getConfigStatic('app.exception.handler'));
            set_error_handler(static::getConfigStatic('app.error.handler'));
        }

    }