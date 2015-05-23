<?php

use Gem\Components\View;
use Gem\Components\Captcha;
use Gem\Components\Crypt;
use Gem\Components\Gem\Components;

## g�r�nt� dosyas� olu�turur

function view($path, $variables = [], $language = [], $autoload = true) {
    $view = new View();
    $view->make($path, $variables)->language($language)->autoload($autoload)->execute();
}

##captcha_create

function captcha($options = []) {

    $captcha = new Captcha($options);
    return $captcha;
}

## captchan�n do�ru olup olmad���na bakar

function captchaCheck($string = '') {

    return Captcha::check($string);
}
