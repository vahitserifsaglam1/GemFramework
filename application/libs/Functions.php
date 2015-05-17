<?php


use Gem\Components\View;
use Gem\Components\Captcha;
use Gem\Components\Crypt;
use Gem\Components\Gem\Components;


## görüntü dosyasý oluþturur
function view($path, $variables = [],$language = [],$autoload = true)
{
	$view = new View();
	$view->make($path, $variables)->language($language)->autoload($autoload)->execute();
	
}

##captcha_create

function captcha($options = [])
{
	
	$captcha = new Captcha($options);
	return $captcha;
	
}


## captchanýn doðru olup olmadýðýna bakar
function captchaCheck($string = '')
{
	
	return Captcha::check($string);
	
}

