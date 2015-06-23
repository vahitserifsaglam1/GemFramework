<?php
/**
 * Created by PhpStorm.
 * User: vserifsaglam
 * Date: 22.6.2015
 * Time: 05:20
 */

namespace Gem\components;
use Gem\Components\Helpers\Config;
use Gem\Components\Helpers\LanguageManager;
use Twig_Loader_Filesystem;
use Twig_Environment;
class Twig {

    use Config, LanguageManager;
    private $configs;
    private $autoload;
    private $params;
    private $fileName;

    public function __construct(){

        $this->configs = $this->getConfig('twig');

    }

    /**
     * inc/header.php ve inc/footer.php in yüklenmesi
     * @param bool $au
     * @return $this
     */

    public function autoload($au = false)
    {

        $this->autoload = $au;
        return $this;
    }

    /**
     * Oluşturulacak görüntü dosyasının ön hazırlığını yapar
     * @param $fileName
     * @param array $params
     * @return $this
     */

    public function make($fileName, $params = []){

        $this->fileName = $fileName;
        $this->params = $params;

        return $this;

    }

    /**
     * Görüntü dosyasını oluşturur
     */
    public function display(){

        $content = '';
        $file = $this->fileName.".php";
        $loader = new Twig_Loader_Filesystem(VIEW);
        $twig = new Twig_Environment($loader, $this->configs);
        if($this->autoload === true)
            $content = $twig->render('inc/header.php', $this->params);
        $content .= $twig->render($file, $this->params);
        if($this->autoload === true)
            $content .= $twig->render('inc/footer.php',$this->params);

        response($content, 200)
                 ->execute();
    }

}