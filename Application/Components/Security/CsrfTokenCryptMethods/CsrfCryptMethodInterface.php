<?php

namespace Gem\Components\Security\CsrfTokenCryptMethods;

interface CsrfCryptMethodInterface {
    public function encrypt($string = '');
}
