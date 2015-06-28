<?php

/**
 *
 *  Bu sınıf GemFramework ' un bir parçasıdır.
 *  İmage vs dosyalarda yol'u oluşturmak için kullanılır.
 * @author vahitserifsaglam1 <vahit.serif119@gmail.com>
 *
 */

namespace Gem\Components\Assets;

use Gem\Components\Assets\AssetInterface;

/**
 * Class PathPackpage
 * @package Gem\Components\Assets
 */
class PathPackpage implements AssetInterface
{

    private $manager;
    private $prefix;
    private $pattern;

    public function __construct($prefix = '', AssetInterface $manager = null)
    {

        $this->setManager($manager);
        $this->setPrefix($prefix);
        $this->pattern = $this->manager->getPattern();
        $this->version = $this->manager->getVersion();

    }

    /**
     * Manager'i döndürür
     * @return AssetInterface
     */
    public function getManager()
    {

        return $this->manager;

    }

    /**
     * Url 'i oluşturucak ana yönetici
     * @param AssetInterface $manager
     * @return $this
     */
    public function setManager(AssetInterface $manager = null)
    {

        $this->manager = $manager;
        return $this;

    }

    /**
     * Prefix ataması yapar
     * @return string
     */
    public function setPrefix($prefix = ''){

         $this->prefix = $prefix;
         return $this;
    }

    /**
     * Atanan prefix' i döndürür
     * @return string
     */
    public function getPrefix(){
        return $this->prefix;
    }

    /**
     * Versionu döndürür
     * @return mixed
     */
    public function getVersion()
    {

        return $this->version;

    }

    /**
     * Pattern'i döndürür
     * @return string
     */

    public function getPattern(){

        return $this->pattern;

    }

    /**
     * Url'i oluşturur
     * @param string $file
     * @return mixed
     */
    public function getUrl($file = '')
    {

        return $this->manager->getUrl($file, $this->getPrefix());

    }


}
