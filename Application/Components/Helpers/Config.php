<?php

    /**
     * GemFramework Config Helper -> ayar dosyaları bu dosyadan çekilir
     *
     * @package Gem\Components\Helpers
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     */

    namespace Gem\Components\Helpers;

    use Gem\Components\Config\Reposity;
    use Gem\Components\Patterns\Facade;

    class Config extends Facade
    {
        protected static function getFacadeClass()
        {
            return Reposity::class;
        }

    }
