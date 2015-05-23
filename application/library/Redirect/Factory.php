<?php
/**
 *  Bu Dosya GemFramework'un bir parçasıdır,
 *  Response Sınıfının gerekli olan kısımları burada düzenlenir.
 * 
 */
namespace Gem\Components\Redirect;
use Gem\Components\Helpers\Config;
class Factory
{
    
    use Config;
    private static $url;

    /**
     * Çağrılan adres uzak sunucudamı yoksa yerelmi olup olmadığını anlar;
     * @param type $url
     * @return type
     */

    protected static function isUrl($url)
    {
        
         $baslangic = substr($url, 0, 10);
         if(strstr($baslangic, "http://") ||strstr($baslangic, "http://www.") || strstr($baslangic, "www.") || strstr($baslangic, "https://")
           || strstr($baslangic, "https://www"))
         {
             return $url;
         }else{
             return self::getUrl().$url;
         }
        
        
    }
    
    /**
     * framework'un çalıştığı url'i döndürür
     * @return string
     */
    private static function getUrl(){
        
        if(!self::$url)
        {
            
            self::$url = static::getConfigStatic('configs')['url'];
            
        }
        
        return self::$url;
        
    }
    
    protected static function refresh($url, $time)
    {
        
            header("Refresh:{$time},url=$url");
    }
    
    protected static function location($url)
    {
        
        header("Location:$url");
        
    }
    
}