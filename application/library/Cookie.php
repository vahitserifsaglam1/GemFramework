<?php
    /**
     * 
     * GemFramework Cookie Sýnýfý, Cookie iþlemleri yapýlýrken hýzlý bir biçimde kullanýlýr
     * @package Gem\Components
     * @author vahitserifsaglam1 <vahit.serif119@gmail.com>
     * 
     */
 

    namespace Gem\Components;

    class Cookie{
        
        /**
         * tum cookieleri temizler
         */
		
        public static function flush()
        {
			

            foreach($_COOKIE as  $key => $value)
			
            {
				
                static::delete($key);
				
            }
			
        }

        /**
         * cookie atamasÄ± yapar, $name degeri zorunludur ve string dir, $time integer girilmelidir
         * @param string $name
         * @param mixed $value
         * @param integer $time
         */
        public static function set($name = '',$value,$time= 3600)
        {
			if(is_string($value)){
                setcookie($name,$value,time()+$time);
            }

            if(is_array($value)){

                foreach($value as $values){

                    setcookie("$name[$values]",$values ,time()+$time);

                }



            }
			
        }
        
        /**
         *  
         *  Girilen $name degerine gore¶re cookie olup olmadÄ±ÄŸÄ±nÄ± kontrol eder varsa cookie i dï¿½ndï¿½rï¿½r yoksa false dï¿½ner
         *  
         * @param string $name
         * @return mixed|boolean
         */

        public static function get($name = '')
        {
			
             return $_COOKIE[$name];
			
        }


        /**
         * 
         *  girilen $name degiskenine gore varsa silinir yoksa exception oluï¿½tururlur
         * 
         * @param string $name
         * @throws Exception
         */
        public static function delete($name = '')
        {
			
            if(isset($_Cookie[$name])) setcookie($name,'',time()-29556466);else throw new Exception(" $name diye bir cookie bulunamadÄ± ");
			
        }
        
        /**
         * Varmý yokmu diye bakar
         * @param unknown $name
         * @return boolean
         */
        
        public static function has($name)
        {
        	
        	if(isset($_COOKIE[$name]))
        		return true;
        	
        }
    }