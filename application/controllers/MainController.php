<?php
/**
 * 
 *  Bu Sınıf GemFramework'e ağit bir sınıftır.
 *  Temel olarak controller objemizden view ve model'imizi yönetmemizi sağlar.
 * 
 *  @packpage Gem\Controllers
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 *  @copyright (c) 2015, Vahit Şerif Sağlam
 * 
 */

namespace Gem\Controllers;

use Gem\Components\App;
use ReflectionClass;

class MainController{
    
    protected $model;

    /**
     * Bir Components import eder.
     * @param $name
     * @param array $parametres
     * @return mixed
     */
    public function import($name, $parametres = []){

        $name = "Gem\\Components\\".$name;
        $classs = new ReflectionClass($name);
        $setParameters = $classs->newInstanceArgs($parametres);
        return $setParameters;

    }
    
    /**
     * 
     * Controller'in modelini atar.
     * @param mixed $model
     * @return mixed
     */
    public function model($model)
    {
        
        if(!is_object($model) && is_string($model))
        {
            
            $model = App::uses($model, 'Model');
            
        }
        
        $this->model = $model;
        return $this->model;
        
    }

    /**
     * Dinamik olarak model den fonksiyon çağrımı
     * @param $method
     * @param array $params
     * @return mixed
     */
    public function __call($method, $params = [])
    {

        return call_user_func_array([$this->model, $method], $params);

    }
}
