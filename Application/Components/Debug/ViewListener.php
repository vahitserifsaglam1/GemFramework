<?php

namespace Gem\Components\Debug;

use Gem\Components\Adapter\AdapterInterface;

class ViewListener implements AdapterInterface, DebugInterface{

    private $viewList;
    public function getName()
    {
        return "view";
    }

    /**
     * Sınıfı başlatır
     */
    public function boot()
    {
        $this->viewList = [];
    }

    /**
     * Dinlenen içeriğe yenisini ekler
     * @param string $list
     */
    public function addToList($list = '')
    {
        $this->viewList[] = $list;
    }

    /**
     * Sınıfı temizler
     * @return $this
     */
    public function clean()
    {
        $this->boot();
        return $this;
    }

    /**
     * View verilerini döndürür
     * @return mixed
     */
    public function getAll()
    {
        return $this->viewList;
    }
}