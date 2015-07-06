<?php
namespace Gem\Manager\Providers;

use Gem\Components\Helpers\Server;
use Gem\Components\Security\CsrfToken;
use Gem\Components\Security\CsrfTokenCryptMethods\Md5Crypt;

/**
 * Class CsrfTokenProvider
 * @package Gem\Manager\Providers
 */
class CsrfTokenProvider
{
    use Server;
    private $fieldName = '_token';
    public function __construct()
    {
        $class = new CsrfToken();
        $class->setFieldName($this->fieldName);
        $class->setCryptMethod(new Md5Crypt());
        session($this->fieldName, $class->getSecretKey());
        session('CsrfTokenSessionName', $this->fieldName);
        if($this->getMethod() === 'POST')
        {
            $class->run();
        }
    }
}
