<?php

/**
 *
 * GemFramework Cookie işlemlerinin yapıldığı sınıf
 * @package Gem\Components
 * @author vahitserifsaglam1 <vahit.serif119@gmail.com>
 *
 */

namespace Gem\Components;

use Gem\Components\Http\CookieJar;
use Gem\Components\Patterns\Singleton;
class Cookie
{

    public $cookies;
    private $headerBag;
    public function __construct(){

        $this->cookies = Singleton::make('Gem\Components\Http\CookieBag')->getCookies();
        $this->headerBag = Singleton::make('Gem\Components\Http\Response\HeadersBag');

    }

    /**
     * Cookie 'i döndürür
     * @param string $name
     * @return mixed
     */
   public function get($name = '')
   {

       return $this->cookies[$name];

   }

    public function has($name = ''){

        return isset($this->cookies[$name]);

    }

    /**
     *
     * Cookie Atamasını yapar
     * $name -> cookie adı
     * $value -> cookie değeri
     * $expires -> geçerlilik süresi
     * $path->cookie nin geçerli olacağı alan
     * $domain->cookie'in geçerli olduğu domain
     * $sucere->cookie'nin secure değeri
     * $httpOnly -> cookie'in httpony değeri
     *
     * @param string $name
     * @param string $value
     * @param int $expires
     * @param string $path
     * @param null $domain
     * @param bool $secure
     * @param bool $httpOnly
     * @return $this
     */
    public function set($name = '', $value = '', $expires = 0, $path = '/', $domain = null, $secure = false, $httpOnly = false)
    {

        $this->headerBag->setCookie(new CookieJar($name, $value, $expires, $path, $domain, $secure, $httpOnly));
        return $this;

    }

    /**
     * Silme işlemini yapar
     * @param string $name
     * @return $this
     */
    public function delete($name = ''){

        $this->set($name, '');
        return $this;
    }

    /**
     * Tüm cookileri temizler
     */
    public function flush(){

        foreach($this->cookies as $cookie => $value)
        {

            $this->delete($cookie);

        }

    }

}
