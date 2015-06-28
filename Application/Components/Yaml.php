<?php

namespace Gem\Components;

/*
 * @author vahitserifsaglam1 <vahit.serif119@gmail.com>
 * @packpage Gem\Components 
 * @version 1
 * 
 */
use Symfony\Component\Yaml\Yaml as Symfony;
use RuntimeException;
use Exception;

class Yaml
{


    /**
     * Girilen yaml içeriğini parçalar
     * @param string $content
     * @return array
     * @throws Exception
     */
    public static function decode($content = '')
    {

        if('' !== $content){

            return Symfony::parse($content);

        }else{

            throw new Exception(
                'Boş bir içerik rende edilemez'
            );

        }

    }

    /**
     *
     * Girilen array içeriğini yaml dosyası türüne dönüştürür
     * @param array $data
     * @return string
     *
     */
    public static function encode(array $data = [])
    {

        try {
            $encoded = Symfony::dump($data);
            return $encoded;
        } catch (Exception $e) {

            throw new RuntimeException(sprintf('veriyi encode etme sırasında hata meydana geldi: %s', $e->getMessage()));

        }

    }

}
