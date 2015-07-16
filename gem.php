<?php

    include 'vendor/autoload.php';
    include 'Application/Helpers/helpers.php';
    include 'System/Bootstrap/bootstrap.php';

    $app = new \Gem\Components\Application('ConsoleApp');
    $console = new \Gem\Components\Console\Console($app, 1);


    // yürütürüz
    $console->run();
