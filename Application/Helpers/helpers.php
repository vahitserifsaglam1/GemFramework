<?php

use Gem\Components\Facade\Event as EventDispatcher;
use Gem\Components\Patterns\Singleton;

/**
 * Girilen Event's değerine göre event'i parçalar
 * @param \Gem\Events\Event $event
 * @return mixed
 */
function event(\Gem\Events\Event $event)
{
    return EventDispatcher::fire($event);
}

/**
 * Yeni bir view Objesi döndürür.
 * @param string $file Döndürülecek View Sınıfına atanacak include dosya adı
 * @param array $parametres View sınıfına girilecek parametreler
 * @return \Gem\Components\View
 */
function view($file = '', array $parametres = [])
{
    return (new \Gem\Components\View())->setFileName($file)->setParams($parametres);
}

/**
 * Yeni bir response objesi döndürür
 * @param string $content Gösterilecek içerik
 * @param integer $statusCode İstekçiye gönderilecek durum kodu
 * @return \Gem\components\Http\Response
 */
function response($content = '', $statusCode = 200)
{
    return Singleton::make('\Gem\Components\Http\Response', [$content, $statusCode]);

}

/**
 * Eğer hiç paremetre girilmez ise düz olarak session objesini döndürür,
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
 * Base Href adresini döndürür
 * @return string
 */
function base()
{
    return \Gem\Components\App::base();
}

/**
 * Csrf token kodunu döndürür
 * @return string
 */
function csrfActive()
{
    $session = session();
    if($session->has('CsrfTokenSessionName'))
    {
        $sessionName =  $session->get('CsrfTokenSessionName');
        if($session->has($sessionName))
        {
            return $session->get($sessionName);
        }
    }

    return false;
}