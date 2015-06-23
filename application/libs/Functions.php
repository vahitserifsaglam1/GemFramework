<?php

use Gem\Components\View;
use Gem\Components\Captcha;
use Gem\Components\Twig;
## görüntü dosyasını oluşturur.

function view($path ='', array $variables = [], array $language = [], $autoload = true) {
    $view = new View();
    $view->make($path, $variables)->language($language)->autoload($autoload)->execute();
}

function twig($path, array $variables = [], array $language = [], $autoload = true) {
    $view = new Twig();
    $view->make($path, $variables)->language($language)->autoload($autoload)->execute();
}


/**
 * Captcha a ait bir instace döndürür
 * @staticvar Captcha $captcha
 * @param array $options
 * @return Captcha
 */
function captcha(array $options = []) {
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

function xss_protection($data = ''){

    $data = str_replace(['"',"'","<",">","&lt;"],'',$data);
    if(!is_string($data)){

        echo sprintf('%s veri tipi %s fonksiyonunda kullanılamaz', gettype($data), __FUNCTION__);

    }

    $data = strip_tags(
        htmlspecialchars(
            htmlentities($data)
        )
    );



    return $data;

}

/**
 * Epostanın geçerli olup olmadığına bakar
 * @param string $mail
 * @return mixed
 */
function validateEmail($mail = ''){

    return filter_var($mail, FILTER_VALIDATE_EMAIL);

}

/**
 * Url i kontrol eder
 * @param string $url
 * @return mixed
 */
function validateUrl($url = ''){

    return filter_var($url, FILTER_VALIDATE_URL);

}

/**
 * Yeni bir response objesi döndürür
 * @param string $content
 * @param int $statusCode
 */
function response($content = '', $statusCode=200){

    return new Gem\Components\Http\Response($content, $statusCode);

}
