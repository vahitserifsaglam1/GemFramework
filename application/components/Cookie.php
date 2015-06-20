<?php

/**
 *
 * GemFramework Cookie S�n�f�, Cookie i�lemleri yap�l�rken h�zl� bir bi�imde kullan�l�r
 * @package Gem\Components
 * @author vahitserifsaglam1 <vahit.serif119@gmail.com>
 *
 */

namespace Gem\Components;

use InvalidArgumentException;

class Cookie
{

    /**
     * tum cookieleri temizler
     */
    public static function flush()
    {


        foreach ($_COOKIE as $key => $value) {

            static::delete($key);
        }
    }

    /**
     * cookie ataması yapar, $name degeri zorunludur ve string dir, $time integer girilmelidir
     * @param string $name
     * @param mixed $value
     * @param integer $time
     */
    public static function set($name = '', $value, $time = 3600)
    {
        if (is_string($value)) {
            setcookie($name, $value, time() + $time);
        }

        if (is_array($value)) {

            foreach ($value as $values) {

                setcookie("$name[$values]", $values, time() + $time);
            }
        }
    }

    /**
     *
     *  Girilen $name degerine gore�re cookie olup olmadığını kontrol eder varsa cookie i d�nd�r�r yoksa false d�ner
     *
     * @param string $name
     * @return mixed|boolean
     */
    public static function get($name = '')
    {

        return $_COOKIE[$name];
    }

    /**
     *
     *  girilen $name degiskenine gore varsa silinir yoksa exception olu�tururlur
     *
     * @param string $name
     * @throws Exception
     */
    public static function delete($name = '')
    {

        if (isset($_Cookie[$name]))
            setcookie($name, '', time() - 29556466);
    }

    /**
     * Varm� yokmu diye bakar
     * @param unknown $name
     * @return boolean
     */
    public static function has($name = null)
    {

        if ($name !== null && is_string($name)) {

            if (isset($_COOKIE[$name]))
                return true;
        } elseif (is_null($name)) {

            return (count($_COOKIE) > 0) ? true : false;
        } else {

            throw new InvalidArgumentException(sprintf('%s Sınıfı %s fonksiyonuna parametre olarak sadece string girilebilir', 'Cookie', 'has'));
        }
    }

}
