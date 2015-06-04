<?php

/**
 * 
 * GemFramework Server Helper -> $_SERVER ile ilgili işlemleri yapar
 * 
 * @package Gem\Components\Helpers
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * 
 */

namespace Gem\Components\Helpers;

trait Server {

    public $url;

    /**
     * @var array
     *  Ã–zel arama terimleri
     */
    public $server_filters = [
        'useragent' => 'HTTP_USER_AGENT',
        'referer' => 'HTTP_REFERER',
        'host' => 'HTTP_HOST',
        'reditect' => 'REDIRECT_URL',
        'serverip' => 'SERVER_ADDR',
        'userip' => 'REMOTE_ADDR',
        'uri' => 'REQUEST_URI',
        'method' => 'REQUEST_METHOD',
        'protocol' => 'SERVER_PROTOCOL'
    ];

    /**
     * Özel terimlerden getirme
     * @param string $name
     * @return unknown
     */
    public function get($name = 'HTTP_HOST') {
        if (isset($_SERVER[$name])) {
            return $_SERVER[$name];
        }
    }

    /**
     * Url i döndürür
     * 
     * @return string
     */
    public function getUrl() {

        $this->url = $_GET['url'];

        return $this->url;
    }

    /**
     * Dinamik çağırma
     * @param unknown $name
     * @throws \Exception
     * @return string
     */
    public function __get($name) {
        if (isset($this->server_filters[$name])) {
            return $_SERVER[$this->server_filters[$name]];
        } else {
            $big = mb_convert_case($name, MB_CASE_UPPER, 'UTF-8');
            if (isset($_SERVER[$big])) {
                return $_SERVER[$big];
            } else {
                throw new \Exception(sprintf("%s adında bir değişken bulunamadı", $name));
            }
        }
    }

    /**
     * Çalıştığı url i bulur
     */
    public function findBasePath() {

        $host = $this->host;
        $uri = $this->uri;
        $type = $this->get('REQUEST_SCHEME');
        $url = "$type://$host . $uri";
        return $url;
    }
    

    /**
     * Kullanıcının ip adresini döndürür
     * @return string
     */
    public function getIP() {
        if (getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
            if (strstr($ip, ',')) {
                $tmp = explode(',', $ip);
                $ip = trim($tmp[0]);
            }
        } else {
            $ip = getenv("REMOTE_ADDR");
        }
        return $ip;
    }

}
