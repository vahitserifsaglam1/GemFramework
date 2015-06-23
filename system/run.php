<?php

use Gem\Components\Application;

## uygulamayı başlatan ana sınıf
$application = new Application('GemFrameworkBuild', 1);

/**
 *
 *  Rotalama olayının application/routes.php den devam edeceğini bildirir.
 *  İstenilirse ->routesFromFile( den önce istenilen işlemler yapılabilir.
 *
 */
$application->provider([
    'Gem\Modules\Providers\Event'
])->routesFromFile(APP . 'routes.php');
