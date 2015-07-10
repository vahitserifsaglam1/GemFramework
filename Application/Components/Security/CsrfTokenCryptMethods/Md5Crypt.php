<?php
namespace Gem\Components\Security\CsrfTokenCryptMethods;
class Md5Crypt extends CsrfCryptMethod {

    public function encrypt($string = '')
    {
        return md5($string);
    }

}