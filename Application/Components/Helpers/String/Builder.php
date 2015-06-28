<?php

/**
 *
 *  GemFramework String Builder Trait -> metinleri birle�tirirken
 *  kullan�lacak baz� fonksiyonlar� i�erir
 *
 * @package Gem\Components\Helpers\String
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @version 1.0
 *
 */

namespace Gem\Components\Helpers\String;

trait Builder
{

    /**
     * Verilen diziyi bir string haline getirir
     * @param array $array
     * @param string $joiner
     * @return string
     * @access public
     *
     */
    public function joinWithImploder(array $array = [], $joiner)
    {

        return join($joiner, $array);
    }

    /**
     * . l� metni / e �evirir
     * @param unknown $dot
     * @return string
     */
    public function joinDotToUrl($dot)
    {

        return $this->replaceString(".", "/", $dot);
    }

    /**
     * Url linki olu�turur
     * @param array $url
     * @return string
     */
    public function joinUrl(array $url = [])
    {

        return $this->joinWithImploder($url, '/');
    }

    /**
     * . yap�s�nda bir veri olu�turur
     * @param array $dor
     * @return string
     */
    public function joinWithDot(array $dor = [])
    {

        return $this->joinWithImploder($dot, '.');
    }

    /**
     *
     * @param mixed $search
     * @param mixed $replace
     * @param string $string
     * @return string
     * @access public
     */
    public function replaceString($search, $replace, $string)
    {

        return str_replace($search, $replace, $string);
    }

    /**
     *
     * @param string $url
     * @param string $action
     * @return array
     */
    public function routeGenerateParams($url = '', $action)
    {

        ## parametreler
        $params = [];

        $argument_keys = $this->createArgumentKeys($action);

        if (count($argument_keys) > 0) {

            foreach ($argument_keys as $key => $value) {

                $matches = explode("/", $url);

                if (isset($matches[$key])) {

                    $params[$value] = $matches[$key];
                }
            }
        }

        return ['args' => $argument_keys,
            'params' => $params];
    }

    /**
     *
     * @param array $replaces
     * @param array $params
     * @param string $url
     * @return string
     */
    public function routeGenareteNewUrl($replaces, $params, $url, $action)
    {


        $replaced = $this->replaceString($replaces, $params, $action);

        if ($replaced == $url) {

            return true;
        }
    }

    public function clearLastSlash($url)
    {

        $len = strlen($url);
        if (substr($url, $len - 1, $len) == "/") {

            $url = substr($url, 0, $len - 1);
        }
        return $url;
    }

    /**
     * Argsları hazırlar
     * @param string $action
     * @return multitype:|unknown
     */
    private function createArgumentKeys($action)
    {

        return array_filter(
            $this->urlParser($action), function ($a) {

            if (preg_match("/:([\w-%]+)/", $a, $find)) {


                return $find[1];
            }
        }
        );
    }

}
