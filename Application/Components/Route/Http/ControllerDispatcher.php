<?php
/**
 *  Bu Sınıf GemFramework' Route olayında kullanılacak Controllerler için kullanılır.
 *
 */
namespace Gem\Components\Route\Http;
use Gem\Components\Route\Http\Dispatch;
use Exception;
class ControllerDispatcher extends Dispatch{

    /**
     * Controller ataması yapar
     * @param null $controller
     * @return $this
     */
   public function setController($controller = null)
   {
       $this->setRouteControllerForDispatch($controller);
       return $this;
   }

    /**
     * Callable atamasını engeller
     * @param null $callable
     * @throws Exception
     */
    public function setCallable($callable = null)
    {

        throw new Exception('%s sınıfından callable ataması yapamassınız', __CLASS__);

    }

}