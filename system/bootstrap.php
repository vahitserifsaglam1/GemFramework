<?php

## başlatma dosyası

## uygulama klas�r�n�n sabiti

define('APP', 'application/');

## g�r�nt� klas�r�n�n sabiti
define('VIEW', APP . 'Views/');

## model lerin tutulduğu klasör sabiti
define('MODEL', APP . 'Models/');

## controller tutulduğu klasör sabiti
define('CONTROLLER', APP . 'Controllers');

## ayarların ulduğu klasör sabiti
define('CONFIG_PATH', APP . 'Configs/');


## sistemin ulduğu klasör sabiti
define('SYSTEM', 'system/');

## dil dosyalar�n�n oldu�u klas�r
define('LANG', 'language/');


include APP . 'libs/Functions.php';

include SYSTEM . 'run.php';




