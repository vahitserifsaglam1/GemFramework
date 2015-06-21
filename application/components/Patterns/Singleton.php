<?php

/**
 * Bu dosya GemFramework 'un Singleton Desing Pattern
 * S�n�f�na ait bir dosyad�r, Singleton Pattern bu s�n�f �zerinden �al���r.
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @package Gem\Components\Patterns
 * @copyright MyfcYaz�l�m
 *
 */

namespace Gem\Components\Patterns;

use ReflectionClass;

class Singleton
{

    /**
     *
     * @var Object, Integer
     * @access private
     *
     * Sınıfların toplam instance sayısını tutar
     *
     */
    private static $instances,
        $instances_count = 0;

    /**
     * Yeni bir instance olu�turur
     * @param mixed $instance
     * @param mixed ...$parametres
     * @access public
     * @return Object
     */
    public static function make($instance, array $parametres = [])
    {

        if (!is_object($instance)) {
            $classs = new ReflectionClass($instance);
            $setParameters = $classs->newInstanceArgs($parametres);
            $instance_name = $instance;
            $instance = $setParameters;
        } else
            $instance_name = get_class($instance);

        if (!isset(self::$instances[$instance_name])) {

            self::$instances[$instance_name] = $instance;
        }

        return self::$instances[$instance_name];
    }

}
