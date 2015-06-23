<?php

## başlatma dosyası

## uygulama klasörün sabiti

define('APP', 'application/');

## Görüntü dosyalarının bulunacağı klasör sabiti
define('VIEW', APP . 'Views/');

## model lerin tutulduğu klasör sabiti
define('MODEL', APP . 'Models/');

## controller tutulduğu klasör sabiti
define('CONTROLLER', APP . 'Controllers');

## ayarların ulduğu klasör sabiti
define('CONFIG_PATH', APP . 'Configs/');


## sistemin ulduğu klasör sabiti
define('SYSTEM', 'system/');

## dil dosyalarının olduğu klasörün sabiti
define('LANG', 'language/');


include APP . 'libs/Functions.php';

include SYSTEM . 'run.php';




