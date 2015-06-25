<?php
/**
 * Created by PhpStorm.
 * User: vserifsaglam
 * Date: 24.6.2015
 * Time: 20:54
 */

namespace Gem\Components\View;


class FooterBag {
    private $viewFooters = [

        'inc/header.php'

    ];

    /**
     *
     * @param array $Footers
     * @return $this
     */
    public function setViewFooters(array $footers = [])
    {
        if (!is_array($footers)) {

            $footers = (array)$footers;

        }
        $this->viewFooters = $footers;
        return $this;
    }

    /**
     * İndex.php den sonra yüklenecek dosyalar çekilir
     * @return array
     */
    public function getViewFooters(){

        return $this->viewFooters;

    }
}