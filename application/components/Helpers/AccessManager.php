<?php

/**
 * 
 * Bu trait GemFramework'un yardımcılarından biridir, bir olaya erişim hakkınızın olup olmadığını kontrol eder.
 * @see Laravel\Middleware
 * @see GemFramework\AccessManager
 * @copyright (c) 2015, MyfcYazilim
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * 
 */

namespace Gem\Components\Helpers;

use Gem\Components\Helpers\AccessManager\Interfaces\Handle;
use Gem\Components\Helpers\AccessManager\Interfaces\Terminate;
use Gem\Components\Request;
use RuntimeException;

trait AccessManager {

    private $access;

    /**
     * Geçerli bir access atanmışmı diye bakar
     * @param string $name
     * @return string|boolean
     */
    public function getAccess($name) {

        if (isset($this->access[$name])) {

            return $this->access[$name];
        } else {

            return false;
        }
    }

    /**
     * Fonksiyonları tetikleyerek dönen verileri alır
     * @param string $name
     * @param Closure $next
     * @param string $role
     * @return boolean
     */
    public function checkAccess($name, $next, $role = null) {

        if ($access = $this->getAccess($name)) {

            $manager = new $access;

            if ($manager instanceof Handle) {
                $request = new Request();
                $response = $manager->handle($request, $next, $role);
                if ($response) {

                    return true;
                } elseif ($manager instanceof Terminate) {

                    $response = $manager->terminate($request);
                    if ($response) {

                        return true;
                    }
                }
            } else {

                throw new RuntimeException(sprintf('%s isimli AccessManager sınıfınız %s interface\'ine sahip olmalıdır ', $name, 'Gem\Components\AccessManager\Interfaces\Handable'));
            }
        } else {

            throw new RuntimeException(sprintf('%s isimli bir AccessManager bulunamadı', $name));
            return false;
        }
    }

    /**
     * AccessAtaması yapar
     * @param array $access
     */
    public function setAccess(array $access = []) {

        $this->access = $access;
    }

}
