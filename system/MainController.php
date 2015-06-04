<?php
/**
 * 
 *  Bu Sınıf GemFramework'e ağit bir sınıftır.
 *  Temel olarak controller objemizden view ve model'imizi yönetmemizi sağlar.
 * 
 *  @packpage 
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 *  @copyright (c) 2015, Vahit Şerif Sağlam
 * 
 */

use Gem\Components\View;
use Gem\Components\App;

class MainController{
    
    protected $view;
    protected $model;
    
    /**
     * 
     * Yeni bir instance Oluşturur ve sınıf paremetresi olan $view'e bir instance atar.
     * 
     */
    
    public function __construct() {
        $this->view = new View();
    }
    
    /**
     * 
     * Controller'in modelini atar.
     * @param mixed $model
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