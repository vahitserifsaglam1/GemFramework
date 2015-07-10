<?php
    /**
     *  Bu Dosya içinde Rötalarınızı toplayabilirsiniz
     *
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     */

    use Gem\Components\Facade\Route;
    use Gem\Components\Route\Http\ControllerManager;

    Route::get('/', function(ControllerManager $manager){
       return $manager->setController('Index::open');
    });
