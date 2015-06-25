<?php

/**
 *
 *  Bu sınıf response sınıfı için içerikleri toplar.
 *
 */

namespace Gem\Components\Http\Response;


class HeadersBag {

    public $headers = [];
    private $cookies = [];

    /**
     * header ataması yapar
     * @param string $header
     * @param null $value
     * @return $this
     */
    public function header($header = '', $value=null){

        if(is_string($header) && !is_null($value))
        {
            $this->headers[$header] = $value;
        }elseif(is_array($header) && is_null($value)){
            $this->headers = arrray_merge($this->headers, $header);
        }

        return $this;

    }

    /**
     * Headerları döndürür
     * @return mixed
     */
    public function getHeaders(){

        return $this->headers;

    }

    /**
     * Cookie Ataması Yapar
     * @param string $cookie
     */
    public function setCookie($cookie = null){

        $this->cookies[] = $cookie;

    }

    public function getCookies(){

        return $this->cookies;

    }
}

