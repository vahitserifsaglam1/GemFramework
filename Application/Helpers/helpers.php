<?php

    use Gem\Components\Facade\Event as EventDispatcher;
    use Gem\Components\Patterns\Singleton;
    use Gem\Components\Http\Input;

    /**
     * Girilen Event's değerine göre event'i parçalar
     *
     * @param \Gem\Events\Event $event
     * @return mixed
     */
    function event(\Gem\Events\Event $event)
    {
        return EventDispatcher::fire($event);
    }

    /**
     * Yeni bir view Objesi döndürür.
     *
     * @param string $file Döndürülecek View Sınıfına atanacak include dosya adı
     * @param array  $parametres View sınıfına girilecek parametreler
     * @return \Gem\Components\View
     */
    function view($file = '', array $parametres = [])
    {
        return (new \Gem\Components\View())->setFileName($file)->setParams($parametres);
    }

    /**
     * yeni bir twig objesi oluşturur
     *
     * @param       $file
     * @param array $parametres
     * @return $this
     */

    function twig($file, array $parametres = [])
    {
        return (new \Gem\Components\Twig())->setFileName($file)->setParams($parametres);
    }

    /**
     * Yeni bir response objesi döndürür
     *
     * @param string  $content Gösterilecek içerik
     * @param integer $statusCode İstekçiye gönderilecek durum kodu
     * @return \Gem\components\Http\Response
     */
    function response($content = '', $statusCode = 200)
    {
        return Singleton::make('\Gem\Components\Http\Response', [$content, $statusCode]);
    }

    /**
     * Eğer hiç paremetre girilmez ise düz olarak session objesini döndürür,
     *
     * @param null $get eğer sadece bu parametre girilirse Session::get çalıştırılır
     * @param null $set bu parametre girilirse Session::set çalışır
     * @return mixed
     */
    function session($get = null, $set = null)
    {
        $session = Singleton::make('Gem\Components\Session');
        if ($get !== null && $set === null) {
            return $session->get($get);
        } elseif ($get !== null && $set !== null) {
            return $session->set($get, $set);
        } else {
            return $session;
        }
    }

    /**
     * Eğer hiç paremetre girilmez ise düz olarak Cookie objesini döndürür,
     *
     * @param null $get eğer sadece bu parametre girilirse Cookie::get çalıştırılır
     * @param null $set bu parametre girilirse Cookie::set çalışır
     * @return mixed
     */
    function cookie($get = null, $set = null)
    {
        $cookie = Singleton::make('Gem\Components\Cookie');
        if ($get !== null && $set === null) {
            return $cookie->get($get);
        } elseif ($get !== null && $set !== null) {
            return $cookie->set($get, $set);
        } else {
            return $cookie;
        }
    }

    /**
     * Sonsuza dek sürecek cookie ataması yapar
     * @param        $name
     * @param string $value
     * @return Cookie
     */
    function forever($name, $value = '')
    {
        if(is_string($name) && is_string($value))
        {
            return cookie()->forever($name, $value);
        }else{
            throw new InvalidArgumentException('Cookie ismi veya değeri sadece string değeri alabilir');
        }
    }

    /**
     * Base Href adresini döndürür
     *
     * @return string
     */
    function base()
    {
        return \Gem\Components\App::base();
    }

    /**
     * Csrf token kodunu döndürür
     *
     * @return string
     */
    function csrfActive()
    {
        $session = session();
        if ($session->has('CsrfTokenSessionName')) {
            $sessionName = $session->get('CsrfTokenSessionName');
            if ($session->has($sessionName)) {
                return $session->get($sessionName);
            }
        }

        return false;
    }

    /**
     * @param null $name
     * @param null $controll
     * @return mixed
     */
    function input($name = null, $controll = null)
    {
        if (is_null($controll) && !is_null($name)) {
            return Input::get($name);
        } elseif (!is_null($name) && !is_null($controll)) {
            return Input::set($name, $controll);
        } else {
            return Input::getAll();
        }
    }

    /**
     * Array ın ilk elemanını döndürür
     * @param array $array
     * @return bool
     */
    function first(array $array = [])
    {
        if (count($array) > 0) {
            if (!isset($array[0])) {
                $array = array_values($array);
            }

            return $array[0];
        } else {
            return false;
        }
    }

    /**
     * Dizinin sadece değerlerini döndürür
     * @param array $array
     * @return array
     */
    function values(array $array = [])
    {
        return array_values($array);
    }

    /**
     * Dizinin sadece anahtarlarını döndürür
     * @param array $array
     * @return array
     */
    function keys(array $array = [])
    {
        return array_keys($array);
    }

    /**
     * Asset dosyasının yolunu
     * @param string $asset
     * @return string
     */
    function asset($asset = '')
    {
        $path = new \Gem\Components\Assets\VersionPackpage('', '%v%f');
        return $path->getUrl($asset);
    }