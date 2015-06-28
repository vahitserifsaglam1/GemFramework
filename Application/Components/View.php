<?php

/**
 *
 *  GemFramework View S�n�f� -> G�r�nt� dosyalar� �retmek de kullan�l�r
 *
 */

namespace Gem\Components;


use Exception;
use Gem\Components\Patterns\Singleton;
use Gem\Components\View\Connector;
use Gem\Components\View\ShouldBeViewInterface;

class View extends Connector implements ShouldBeViewInterface
{

    private $file;


    public function __construct()
    {


        parent::__construct();
        $this->file = Singleton::make('Gem\Components\Filesystem');


    }

    private function in($file = '')
    {

        return VIEW . $file.'.php';

    }

    /**
     * Görüntü dosyasını kullanıma hazırlar
     * @param string $fileName
     * @param array $variables
     * @throws Exception
     * @return $this
     */
    public static function make($fileName = '', $variables = [])
    {


        $app = new static();

        $app->fileName = $fileName;
        $app->params = $variables;

        return $app;
    }


    /**
     * Çıktıyı oluşturur
     * @throws Exception
     */
    public function execute()
    {

        $fileName = $this->fileName;
        $variables = $this->params;


        if(true === $this->autoload){

            $this->loadHeaderFiles();

        }


        $this->loadFile($fileName, $variables);

        if(true === $this->autoload){

            $this->loadFooterFiles();

        }

        return ob_get_clean();

    }


    /**
     * Girilen dosyayı yüklemeye çalışır
     * @param string $file
     * @param array $params
     * @return bool
     */
    private function loadFile($file = '', $params = [])
    {


        $file = $this->in($file);
        if ($this->file->exists($file)) {
            $this->file->inc($file, $params);
        } else {

            return false;

        }

    }

    /**
     * Header dosyasını yükler
     * @return bool
     */
    private function loadHeaderFiles()
    {

        $params = $this->params;
        $files = $this->headerBag->getViewHeaders();
        foreach ($files as $file) {

            $this->loadFile($file, $params);

        }

        return true;

    }

    /**
     * Header dosyasını yükler
     * @return bool
     */
    private function loadFooterFiles()
    {

        $params = $this->params;
        $files = $this->footerBag->getViewFooters();

        foreach ($files as $file) {

            $this->loadFile($file, $params);

        }

        return true;

    }
}
