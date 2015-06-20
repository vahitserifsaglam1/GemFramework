<?php
/**
 *  Bu sınıf GemFramework'un örnek bir controller dosyasıdır.
 *  @packpage Gem\Controllers
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 */
namespace Gem\Controllers;
class index extends MainController{
    
    public function __construct(){
 
        parent::__construct();

    }

    public function ornek(){

        echo 'hello world';

    }
    
}