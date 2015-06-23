<?php

/**
 * GemFramework Config Helper -> ayar dosyaları bu dosyadan çekilir
 *
 * @package Gem\Components\Helpers
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 *
 */

namespace Gem\Components\Helpers;

trait Config
{

    /**
     * �stenilen ayar� getirir
     * @param string $config
     * @return boolean|mixed
     * @access public
     *
     */
    public function getConfig($config = '')
    {

        return self::getConfigStatic($config);
    }

    /**
     * �stenilen ayar� getirir
     * @param string $config
     * @return boolean|mixed
     * @access public
     *
     */
    public static function getConfigStatic($config)
    {
        $path = CONFIG_PATH . $config . '.php';

        if (file_exists($path)) {

            return include($path);
        } else {

            return false;
        }
    }

}
