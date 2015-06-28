<?php
/**
 *  Bu sınıf GemFramework'un örnek bir controller dosyasıdır.
 *  @packpage Gem\Controllers
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 */
namespace Gem\Controllers;
use Gem\Components\Http\Response;
class IndexController{


    public function boot(Response $response = null){

        return $response->make($response->view('index')->autoload(true));

    }

}
