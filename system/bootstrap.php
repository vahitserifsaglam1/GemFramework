<?php


## uygulama klasörünün sabiti

define('APP' ,'application/');

## görüntü klasörünün sabiti
define('VIEW' ,APP.'Views/');

## model lerin tutulduðu klasör sabiti
define('MODEL' ,APP.'Models/');

## controller larýn olduðu klasör
define('CONTROLLER' ,APP.'Controllers');

## ayarlarýn olduðu klasör
define('CONFIG_PATH',APP.'Configs/');


## sistem klasörü
define('SYSTEM','system/');

## dil dosyalarýnýn olduðu klasör
define('LANG', 'language/');


include APP.'libs/Functions.php';

## baþlatma iþlemi
include SYSTEM.'run.php';



