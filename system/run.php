<?php

use Gem\Components\Application;
use Gem\Components\Database\Base;


## uygulamayı başlatan ana sınıf
$application = new Application('GemFramework','1.0');




$application->get('/',function (){

  view('index',['test' => 'adsads']);

})
->run();








