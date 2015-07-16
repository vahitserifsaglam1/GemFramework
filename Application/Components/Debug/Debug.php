<?php

    /**
     *  Bu Trait gem.php framework'de view ve veritabanında debug olaylarının yapılabilmesi için tasarlanmıştır
     *  @author vahitserifsaglam <vahit.serif119@gmail.com>
     */
namespace Gem\Components\Debug;

use Gem\Components\Patterns\Singleton;

/**
 * Trait Debug
 *
 * @package Gem\Components\Debug
 */

trait Debug {

    private $debugInstance;
    public function debugBoot()
    {
        $this->debugInstance = Singleton::make('Gem\Components\Debug\DebugListener');
    }

    /**
     * Tüm verileri döndürür
     * @return mixed
     */
    public function getAllDebugValues()
    {
        return $this->debugInstance->getListenedValues();
    }
    /**
     * View 'e atar
     * @param array $pro
     */
    public function addToView($pro = [])
    {
        $this->debugInstance->view->addToList($pro);
    }

    public function addToDatabase($pro = [])
    {
        $this->debugInstance->database->addToList($pro);
    }
}