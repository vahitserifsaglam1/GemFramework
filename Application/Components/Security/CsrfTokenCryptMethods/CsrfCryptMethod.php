<?php

    namespace Gem\Components\Security\CsrfTokenCryptMethods;

    abstract class CsrfCryptMethod
    {
        abstract public function encrypt($string = '');
    }
