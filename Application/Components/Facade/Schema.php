<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Facade;

    use Gem\Components\Patterns\Facade;
    use Gem\Components\Patterns\Singleton;

    /**
     * Class Schema
     * @package Gem\Components\Facade
     */
    class Schema extends Facade
    {
        /**
         * @return Object
         */
        protected static function getFacadeClass()
        {
            return Singleton::make('Gem\Components\Database\Tools\Migration\Schema');
        }
    }