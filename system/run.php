<?php

use Gem\Components\Application;

## uygulamayı başlatan ana sınıf
$application = new Application('GemFramework', '1.0');

/**
 * 
 *  Rotalama olayının application/routes.php den devam edeceğini bildirir.
 *  İstenilirse ->run() dan önce başka işlemlerde yapılabilir
 * 
 */
$application->routesFromFile(APP . 'routes.php');
