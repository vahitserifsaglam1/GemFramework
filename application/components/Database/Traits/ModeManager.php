<?php

/**
 *
 *  GemFramework Model Manager, Database Sınıfına yeni modlar eklenmesi bu sınıfta gerçekleşir
 *
 * @package  Gem\Components\Database\Traits;
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 */

namespace Gem\Components\Database\Traits;

use Gem\Components\Database\Mode\ModeManager as Mode;
use BadFunctionCallException;

trait ModeManager
{

    private $modes;

    /**
     *
     * Böyle bir mod varmı yokmu diye kontrol eder
     * @param string $modeName
     * @return boolean
     */
    public function isMode($modeName)
    {

        return isset($this->modes[$modeName]);
    }

    /**
     * Modu getirir
     * @param string $modeName
     * @return mixed
     */
    public function getMode($modeName)
    {

        return $this->modes[$modeName];
    }

    /**
     * Mode Çağırması yapar
     * @param type $modeName
     * @param type $modeArgs
     * @return type
     */
    public function callMode($modeName, $modeArgs)
    {

        return call_user_func_array($this->getMode($modeName), $modeArgs);
    }

    /**
     *
     * @param type $modeName
     * @param callable $callback
     * @return $this
     * @throws BadFunctionCallException
     */
    public function addMode($modeName, callable $callback)
    {

        $call = $callback();

        if ($call instanceof Mode) {

            $this->modes[$modeName] = $call;
        } else {

            throw new BadFunctionCallException(sprintf('%s callable fonksiyonunuzun %s instance\'ine sahip olması gereklidir', $modeName, 'Gem\Components\Database\Mode\ModeManager'));
        }

        return $this;
    }

}
