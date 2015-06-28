<?php
/**
 *  Bu sınıf GemFramework'un örnek bir controller dosyasıdır.
 *  @packpage Gem\Controllers
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 */
namespace Gem\Controllers;
use Gem\Components\Http\Response;
use Gem\Components\Route\Controller;

/**
 * Class IndexController
 * @package Gem\Controllers
 */
class IndexController extends Controller{

    /**
     *  Starter Function
     */
    public function __construct()
    {

        //

    }

    /**
     * Route tarafından IndexController::boot atandığı için bu tetiklenir.
     * @param Response $response Http\Response sınıfa ait bir instance
     * @return static
     */
    public function boot(Response $response = null){

        return $response->make($response->view('index')->autoload(true));

    }

}
