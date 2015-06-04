<?php 


$app->get('/index/:page', function($page){

    print_r($_SERVER);
    
})->filter('page','[0-9]+')
        ->run();