<?php

namespace Gem\Components;

/*
 * @author vahitserifsaglam1 <vahit.serif119@gmail.com>
 * @packpage Gem\Components 
 * @version 1
 * 
 */
use BadFunctionCallException;
use Gem\Components\Patterns\Singleton;
use RuntimeException;
use Exception;

class Yaml
{

    public function __construct()
    {
        if (!function_exists('yaml_parse')) {
            throw new BadFunctionCallException('yaml_parse fonksiyonu sisteminzde olmadığı için
                    bu sınıfı kullanamassınız');
        }
    }

    /**
     *
     * @param sting $string
     * @return array
     * @throws RuntimeException
     */
    public function decode($string = '')
    {

        try {

            $parsed = yaml_parse($string);
            return $parsed;

        } catch (Exception $ex) {

            throw new RuntimeException('String verisi parçalanırken bir hata oluştu,');

        }

    }

    /**
     * Girilen dosyayı parçalar
     * @param string $file
     * @return array
     * @throws Exception
     */
    public function rende($file = '')
    {

        $file = Singleton::make('Gem\Components\File');
        if ($file->exists($file)) {

            $content = $file->read($file);
            $parse = $this->string($content);
            return $parse;
        } else {

            throw new Exception(sprintf('%s adlı dosya yok yada yazdırılabilir değil', $file));

        }

    }

    /**
     * Girilen urldeki içeriği çekerek kullanır
     * @param string $url
     * @return array
     */
    public function url($url)
    {

        return yaml_parse_url($url);

    }

    /**
     *
     * @param array $data
     * @return string
     *
     */
    public function encode(array $data)
    {

        try {
            $encoded = yaml_emit($data);
            return $encoded;
        } catch (Exception $e) {

            throw new RuntimeException(sprintf('veriyi encode etme sırasında hata meydana geldi: %s', $e->getMessage()));

        }

    }
}
