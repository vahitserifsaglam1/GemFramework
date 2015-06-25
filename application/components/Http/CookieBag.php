<?php
/**
 * Created by PhpStorm.
 * User: vserifsaglam
 * Date: 25.6.2015
 * Time: 18:50
 */

namespace Gem\Components\Http;
use Gem\Components\Http\RequestHeadersBag;
class CookieBag extends RequestHeadersBag{

    private $cookies;

    /**
     * Cookie değerlerini atar
     */
    public function __construct(){

        parent::__construct();
        $get = $this->getHeaders();
        if(isset($get['Cookie'])){

            $this->cookies = $this->rendeCookieString($get['Cookie']);

        }else{

            $this->cookies = [];

        }

    }

    /**
     * Cookie verilerini parçalar
     * @param string $cookie
     * @return array
     */
    private function rendeCookieString($cookie = ''){

        if($cookie !== '')
        {

            $explode = explode(";", $cookie);
            $cookies = [];

            foreach($explode as $ex)
            {

                $ex = explode('=', $ex);
                $cookies[$ex[0]] = $ex[1];

            }

            return $cookies;
        }

    }

    /**
     * Cookileri döndürür
     * @return array
     */
    public function getCookies(){

        return $this->cookies;

    }

}