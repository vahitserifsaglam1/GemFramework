<?php
    /**
     *  Bu Provider İle error ve exception tanımlamarı yapılır
     */
    namespace Gem\Manager\Providers;

    use Gem\Components\Exception\ExceptionHandler;

    /**
     * Class ErrorProvider
     * @package Gem\Manager\Providers
     */
    class ErrorProvider
    {

        public function __construct()
        {
            set_exception_handler([new ExceptionHandler(), 'handleException']);
        }

    }