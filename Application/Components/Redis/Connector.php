<?php

namespace Gem\Components\Redis;
use Exception;
use Redis;
/**
 * Bu sınıf GemFramework'de Redis bağlantısı yapmak için yapılmıştr.
 * Class Connector
 * @package Gem\Components\Redis
 */
class Connector {

    public function __construct(){

        if(!extension_loaded('redis'))
        {

            throw new Exception('
            Redis eklentisi yüklü olmadan bu sınıfı kullanamassınız.'
            );

        }
        else
        {

            $redisObj = new Redis();
            $redisObj->connect('localhost');

        }

    }

}