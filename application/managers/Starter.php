<?php
/**
 *
 *  Bu Sınıf GemFramework'un başlangıç manager'ı dır, facede alias ları vs tutulur.
 *
 */

namespace Gem\Application\Manager;


class Starter {

    public $alias = [];
    private $providers = [];

    public function setAlias($alias = []){

        $this->alias = array_merge($this->alias, $alias);

    }

    public function getAlias(){

        return $this->alias;

    }

    public function  setProviders($providers){

        $this->providers = array_merge($this->providers, $providers);

    }

    public function getProviders(){
        return $this->providers;
    }

}