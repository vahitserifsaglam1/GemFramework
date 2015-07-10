<?php

    /**
     * Bu dosya GemFramework 'un Singleton Desing Pattern
     * S�n�f�na ait bir dosyad�r, Singleton Pattern bu s�n�f �zerinden �al���r.
     *
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @package Gem\Components\Patterns
     * @copyright MyfcYaz�l�m
     */

    namespace Gem\Components\Patterns;

    use ReflectionClass;

    class Singleton
    {

        /**
         * @var Object, Integer
         * @access private
         * Sınıfların toplam instance sayısını tutar

         */
        private static $instances;
        private static $instances_count = 0;

        /**
         * Yeni bir instance olu�turur
         *
         * @param mixed $instance
         * @param mixed ...$parametres
         * @access public
         * @return Object
         */
        public static function make($instance, array $parametres = [])
        {

            if (is_string($instance)) {
                if (isset(static::$instances[$instance])) {

                    return static::$instances[$instance];
                } else {

                    $createReflectionInstance = new ReflectionClass($instance);
                    $setParamsToCreatedReflectionInstance = $createReflectionInstance->newInstanceArgs($parametres);
                    static::$instances[$instance] = $setParamsToCreatedReflectionInstance;

                    return static::$instances[$instance];
                }
            } elseif (is_object($instance)) {
                $getClassNameFromObject = get_class($instance);
                if (isset(static::$instances[$getClassNameFromObject])) {
                    return static::$instances[$getClassNameFromObject];
                } else {

                    static::$instances[$getClassNameFromObject] = $instance;

                    return $instance;
                }
            }
        }

        /**
         * Toplam kaç içerik olduğunu alır
         *
         * @return int
         */
        public static function getInstanceCount()
        {

            return self::$instances_count;
        }

        public static function getInstances()
        {

            return self::$instances;
        }
    }

