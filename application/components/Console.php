<?php

namespace Gem\Components;
/**
 * Bu sınıf GemFramework'e ait bir konsol uygulamasıdır,
 * Doğru parçalar çıkarılarak ayrı olarakda kullanılabilir
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @package  Gem\Components
 * @copyright (c) 2015, MyfcYazılım
 * 
 */
use Gem\Components\File;
use Gem\Components\Helpers\Config;
use RuntimeException;

class Console {

    use Config;

    private $file;
    private $args;
    private $argc;

    /**
     * 
     * Başlatıcı fonksiyondur,
     * 
     * 
     * @param array $args -> cgi tarafından atanan $args değeridir, 
     * @param integer $argc -> cgi tarafından atanan $argc değeridir, $args ın count'unu tutar
     */
    public function __construct(array $args = [], $argc = 0) {
        $this->file = File::boot();
        if ($this->file->exists('application/'. 'console.php')) {

            $this->file->inc('application/' . 'console.php');
        }

        $this->args = $args;
        $this->argc = $argc;
    }

    public function run() {

        if ($this->argc > 2) {

            list($class, $function) = array_slice($this->args, 0, 2);
            $parameters = array_slice($this->args, 1, count($this->args));
        }
        else{
             
            throw new RuntimeException(sprintf('%s sınıfına %i den az parametre girmişsiniz bu şekilde çalışmaz.',  get_class(), 2));           
            
        }
    }

}
