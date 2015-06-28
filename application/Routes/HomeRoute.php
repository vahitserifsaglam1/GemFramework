<?php
/**
 *
 * Bu sınıf örnek bir
 *
 */
namespace Gem\Routes;
use Gem\Components\Route\RouteHandleInterface;
use Gem\Components\Route\Http\ControllerDispatcher;
use Gem\Components\Http\Response;
class HomeRoute extends ControllerDispatcher implements RouteHandleInterface {

    public function __construct()
    {

    }

    public function handle()
    {

        $this->setController('IndexController::boot');
        $this->dispatch();

    }

}