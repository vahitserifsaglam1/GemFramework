<?php
/**
 * Created by PhpStorm.
 * User: vserifsaglam
 * Date: 22.6.2015
 * Time: 05:20
 */

namespace Gem\components;

use Gem\Components\Helpers\Config;
use Gem\Components\Vıew\Connector;
use Twig_Loader_Filesystem;
use Twig_Environment;
use Gem\Components\Http\Response;
use Gem\Components\View\ShouldBeViewInterface;
use Gem\Components\View\HeaderBag;
use Gem\Components\View\FooterBag;

class Twig extends Connector implements ShouldBeViewInterface
{

    use Config;
    private $configs;
    private $headerBag;
    private $footerBag;
    private $twig;

    public function __construct()
    {

        $this->headerBag = new HeaderBag();
        $this->footerBag = new FooterBag();
        $this->configs = $this->getConfig('twig');

    }


    /**
     * Oluşturulacak görüntü dosyasının ön hazırlığını yapar
     * @param $fileName
     * @param array $params
     * @return $this
     */

    public static function make($fileName = '', $params = [])
    {

        $app = new static();

        $app->fileName = $fileName;
        $app->params = $params;

        return $app;

    }

    /**
     * Görüntü dosyasını oluşturur
     */
    public function execute()
    {

        $content = '';
        $file = $this->fileName . ".php";
        $loader = new Twig_Loader_Filesystem(VIEW);
        $twig = new Twig_Environment($loader, $this->configs);
        $this->twig = $twig;
        if (true === $this->autoload )
        {

           $content .= $this->loadHeaderFiles();

        }

        $content .= $twig->render($file, $this->params);

        if (true === $this->autoload) {

            $content .= $this->loadFooterFiles();
        }


        return $content;
    }

    /**
     * İçeriği okur
     * @param $file
     * @param $params
     * @return mixed
     */
    private function loadFile($file, $params){

        return $this->twig->rende($file, $params);

    }
    /**
     * Header dosyasını yükler
     * @return bool
     */
    private function loadHeaderFiles()
    {

        $params = $this->params;
        $files = $this->headerBag->getViewHeaders();

        $content = '';
        foreach ($files as $file) {

            $content .= $this->loadFile($file, $params);

        }

        return $content;

    }

    /**
     * Header dosyasını yükler
     * @return bool
     */
    private function loadFooterFiles()
    {

        $params = $this->params;
        $files = $this->footerBag->getViewFooters();

        $contnet = '';
        foreach ($files as $file) {

            $contnet .= $this->loadFile($file, $params);

        }

        return $contnet;

    }


}
