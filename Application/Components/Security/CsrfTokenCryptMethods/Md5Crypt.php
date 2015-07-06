<?php
namespace Gem\Components\Security\CsrfTokenCryptMethods;
class Md5Crypt implements CsrfCryptMethodInterface {

    public function encrypt($string = '')
    {
        return md5($string);
    }

}