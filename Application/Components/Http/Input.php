<?php

/**
 *
 *  Bu sınıf GemFramework'un bir parçasıdır, request sınıfının içinde veya ayrı olarak $_POST verilerine erişmekte kullanılır
 *  erişmek için kullanılır
 *
 */

namespace Gem\Components\Http;

class Input
{

    /**
     * $name' e atanan veriye göre $_POST da veri varmı yokmu onu kontrol eder
     * @param string $name
     * @return boolean
     */

    public static function has($name = null)
    {

        if ($_POST) {

            return isset($_POST[$name]);
        }
    }

    /**
     * $name'in $_POST içinde var olup olmadığına bakmazsızın veriyi çağırır
     * @param string $name
     * @return mixed
     */
    public static function get($name)
    {

        return $_POST[$name];

    }

    /**
     * $_POST içinde $name'e $value' i atar;
     * @param string $name
     * @param mixed $value
     */
    public static function set($name, $value)
    {

        $_POST[$name] = $value;

    }

    /**
     * $_GET içinden $name'in değerini siler
     * @param string $name
     */
    public static function delete($name)
    {

        unset($_GET[$name]);

    }

    /**
     * @return mixed Post verilerini döndürür
     */
    public function getAll()
    {
        return $_POST;
    }

}
