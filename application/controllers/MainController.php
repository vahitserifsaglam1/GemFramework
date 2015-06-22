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

use Gem\Components\View;
use Gem\Components\App;

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
    
    
}