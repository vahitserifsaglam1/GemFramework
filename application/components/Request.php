<?php
/**
 *
 * Bu sınıf GemFramework'un bir parçasıdır, Http ile ilgili bir çok işlem buradan gerçekleştirilir.
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @copyright (c) 2015,  MyfcYazilim
 *
 */
namespace Gem\Components;

use Gem\Components\Redirect;
use Gem\Components\Helpers\Server;
use Gem\Components\Http\Input;
use Gem\Components\Patterns\Singleton;
use Gem\Components\Session;

class Request
{

    use Server;

    /**
     * Yönlendirme yapar, $time girilirse belirli bi süre bekletilir.
     * @param string $to
     * @param integer $time
     */

    public function redirect($to, $time = null)
    {

        Redirect::to($to, $time);

    }

    /**
     * sessionda $name atandıysa onu döndürür
     * @param string $name
     * @return mixed
     */
    public function session($name)
    {

        if (Session::has($name)) {

            return Session::get($name);

        }

    }


    /**
     * input dan veri çekmekte kullanılır
     * @param string $name
     * @return mixed
     */
    public function input($name)
    {

        return Input::get($name);

    }

    /**
     * UserManager obejsi döndürür
     * @return UserManager
     */

    public function user()
    {

        return Singleton::make('\Gem\Components\Http\UserManager', []);

    }

    /**
     *
     * @return string
     */
    public function host()
    {

        return $this->host;

    }

}

