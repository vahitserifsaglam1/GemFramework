<?php

namespace Gem\Components\Auth;

use Gem\Components\Yaml;
use Exception;
/**
 * Bu sınıf GemFramework'de auth sınıfında kullanılacak tabloları belirlemek için kullanılır
 * Class SchemaBag
 * @package Gem\Components\Auth
 */
class SchemaBag
{

    private $decoded;
    private $yamlFile = APP.'Database/user.yaml';


    public function __construct()
    {


        if(!file_exists($this->yamlFile))
        {

            throw new Exception(
                sprintf('%s yolunda olması gereken user.yaml dosyanız bulunamadı', $this->yamlFile)
            );

        }

        $this->decoded = Yaml::decode(file_get_contents($this->yamlFile));
    }

    /**
     * Parçalanan tabloyu döndürür
     * @return array
     */
    public function getDecodedSchema(){

        return $this->decoded;

    }

    /**
     * Girilen diziyi .yaml a çevirir ve içeriğe atar
     * @param array $encode
     * @return int
     */
    public function setSchemaToFile(array $encode = []){

        return file_put_contents($this->yamlFile, Yaml::encode($encode));

    }

}
