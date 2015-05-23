<?php

use Gem\Components\Application;

## uygulamayı başlatan ana sınıf
$application = new Application('GemFramework', '1.0');

$application->routesFromFile(APP . 'routes.php')
        ->run();








