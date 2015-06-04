<?php

use Gem\Components\View;
use Gem\Components\Captcha;
## g�r�nt� dosyas� olu�turur

function view($path, $variables = [], $language = [], $autoload = true) {
    $view = new View();
    $view->make($path, $variables)->language($language)->autoload($autoload)->execute();
}


/**
 * Captcha a ait bir instace döndürür
 * @staticvar Captcha $captcha
 * @param array $options
 * @return Captcha
 */
function captcha($options = []) {
    static $captcha;
    $captcha = new Captcha($options);
    return $captcha;
}

/**
 * Girilen String'in captcaha ile uyuşup uyuşmadığına bakar
 * @param string $string
 * @return boolean
 */
function captchaCheck($string = '') {

    return Captcha::check($string);
}

