<?php
/**
 *
 * Bu sınıf örnek bir Route Sınıfıdır.
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 *
 */
namespace Gem\Routes;
use Gem\Components\Route\RouteHandleInterface;
use Gem\Components\Route\Http\ControllerDispatcher;
use Gem\Components\Http\Response;
use Gem\Manager\Access\Auth;

/**
 * Class HomeRoute
 * @package Gem\Routes
 */

class HomeRoute extends ControllerDispatcher implements RouteHandleInterface {

    public function __construct()
    {


    }

    public function handle()
    {

        $this->setController('IndexController::boot');
        $this->setAccess(new Auth());
        $this->dispatch();

    }

}