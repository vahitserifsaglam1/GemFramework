<?php

namespace Gem\Components\Http;

use Gem\Components\Session;
use ErrorException;
use Gem\Components\Redirect;
use Gem\Components\Auth;

class UserManager
{


    private $error_page;
    private $error_file;

    const LOGIN = 'GemLogin';

    /**
     * Error tetiklendiğinde yönlendirilecek sayfa atanır
     * @param string $url
     * @return \Gem\Components\Http\UserManager
     */
    public function setErrorPage($url)
    {

        $this->error_page = $url;
        return $this;

    }

    /**
     * Atanan error page veya error file ye göre işlem yapar
     * öncelik error page dedir, eğer atanmışsa o sayfaya yönlendirme yapılır,
     * eğer atanmamışsa error file include edilir
     * @return \Gem\Components\Http\UserManager
     */

    public function error()
    {

        if ($this->error_page) {

            Redirect::to($this->error_page);

        } elseif ($this->error_file) {

            include $this->error_file;

        }


        return $this;

    }


    /**
     * girilen $path daki dosyayı içerik olarak alır
     * @param string $path
     * @return \Gem\Components\Http\UserManager
     * @throws ErrorException
     */
    public function setErrorFile($path)
    {

        if (file_exists($path)) {

            $this->error_file = $path;

        } else {

            throw new ErrorException(sprintf('%s fonksiyonu parametre olarak girdiğiniz %s yolunda herhangi bir dosya bulunamadı', __FUNCTION__, $path));

        }

        return $this;

    }

    /**
     * Kullanıcı girişi yapılıp yapılmadığını kontrol eder
     * @return boolean
     */
    public function isLogined($remember = false)
    {

        return Auth::check($remember);

    }

    /**
     * Userin bu işi yapmaya yetkisi olup olmadığını kontrol eder
     * @param string $role
     * @return boolean
     */
    public function hasRole($role)
    {

        if (!Session::has(self::LOGIN))
            return false;



        $get = Session::get(self::LOGIN)['role'];
        if(strstr($get,",")){
            $get = explode(',', $get);
        }
        if ($get !== 'all') {
            if (array_search($role, $get)) {

                return true;
            }
        } else {

            return true;
        }
    }

}
