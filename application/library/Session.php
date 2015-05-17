<?php
/**
 * 
 *  Gem Framework Session sýnýfý, hýzlý bir biçimde sessionlarý kontrol etmenizi saðlar
 *  @package Gem\Components
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 *  
 */

namespace Gem\Components;


class Session{
    

	/**
	 * Session un olup olmadigini kontrol eder
	 * @param string $name
	 * @return boolean
	 */
    static function has($name)
    {
        
        if(isset($_SESSION[$name])) return true;else return false;
        
    }
    
    /**
     * Atama yapar
     * @param string $name
     * @param mixed $value
     */
    
    static  function set($name,$value)
    {
    
        $_SESSION[$name] = $value;
        
    }
    
    /**
     * Tum sessionlari temizler
     */
    static function flush()
    {
    	
        foreach($_SESSION as $key => $value)
        {
        	
            unset($_SESSION[$key]);
            
        }
        
    }
    
    /**
     * Session u dondurur
     * @param string $name
     * @return mixed|boolean
     */
    public  function get($name)
    {
    	
        return $_SESSION[$name];
    }
    
    /**
     * Session i siler
     * @param string $name
     */
    public  function delete($name)
    {
        if(self::has($name)) unset($_SESSION[$name]);
        else 
        	throw new \Exception(sprintf("%s adinda bir session yok", $name));
    }
    
    
}