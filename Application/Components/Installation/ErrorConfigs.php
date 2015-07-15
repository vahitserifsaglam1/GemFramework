<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Installation;

    use Gem\Components\Helpers\Config;

    class ErrorConfigs
    {

        public function __construct()
        {
            ini_set('display_errors', 'On');
            set_exception_handler(Config::get('app.exception.handler'));
            set_error_handler(Config::get('app.error.handler'));
        }

    }