<?php

use Gem\Components\Application;

$application = new Application('GemFrameworkBuild', 1);
$application->getProvidersAndAliasFromFile(CONFIG_PATH.'general.yaml');
#$application->typeHint(true);
/**
 *
 *  Rotalama olayının Application/routes.php den devam edeceğini bildirir.
 *  İstenilirse -> run ( den önce istenilen işlemler yapılabilir.
 *
 */

$application->run();
