<?php

    include 'vendor/autoload.php';
    include 'Application/Helpers/helpers.php';
    include 'System/Bootstrap/bootstrap.php';
    $app = new \Gem\Components\Application('ConsoleApp');
    $console = new \Gem\Components\Console\Console($app, 1);

    error_reporting(0);
    ini_set('error_reporting', 0);
    ini_set('display_erros', 'Off');
    // yürütürüz
    $console->run();
