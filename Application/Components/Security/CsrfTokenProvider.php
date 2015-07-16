<?php
    namespace Gem\Components\Security;

use Gem\Components\Facade\Request;
use Gem\Components\Security\CsrfTokenCryptMethods\Md5Crypt;

/**
 * Class CsrfTokenProvider
 * @package Gem\Manager\Providers
 */
class CsrfTokenProvider
{
    private $fieldName = '_token';
    public function __construct()
    {
        $class = new CsrfToken();
        $class->setFieldName($this->fieldName);
        $class->setCryptMethod(new Md5Crypt());
        session($this->fieldName, $class->getSecretKey());
        session('CsrfTokenSessionName', $this->fieldName);
        if(Request::isMethod('post'))
        {
            $class->run();
        }
    }
}
