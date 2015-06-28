<?php
/**
 * Created by PhpStorm.
 * User: vserifsaglam
 * Date: 24.6.2015
 * Time: 20:50
 */

namespace Gem\Components\View;

/**
 * Bu sınıf GemFramework View dosyasında header kısmında include edilecek dosyaları toplar, default olarak inc/header.php vardır.
 * Class HeaderBag
 * @package Gem\Components\View
 */

class HeaderBag {

    private $viewHeaders = [

        'inc/header'

    ];

    /**
     *
     * @param array $headers
     * @return $this
     */
   public function setViewHeaders(array $headers = [])
   {
       if (!is_array($headers)) {

           $headers = (array)$headers;

       }
       $this->viewHeaders = $headers;
       return $this;
   }

    /**
     * İndex.php den önce yüklenecek dosyalar çekilir
     * @return array
     */
    public function getViewHeaders(){

        return $this->viewHeaders;

    }
}
