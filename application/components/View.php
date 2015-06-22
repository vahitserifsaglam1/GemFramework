<?php

/**
 *
 *  GemFramework View S�n�f� -> G�r�nt� dosyalar� �retmek de kullan�l�r
 *
 */

namespace Gem\Components;

use Gem\Components\Helpers\String\Parser;
use Gem\Components\Helpers\String\Builder;
use Gem\Components\File;
use Exception;

class View
{

    use Parser,
        Builder;

    private $params, $fileName, $autoload = false, $file;

    public function __construct()
    {

        $this->file = File::boot();
        $this->file->in(VIEW);
        if (!file_exists(VIEW)) {

            throw new Exception(sprintf("%s dosyaniz  bulunamadi", VIEW));
        }
    }

    /**
     * G�r�nt� dosyas� olu�turur
     * @param string $fileName
     * @param array $variables
     * @throws Exception
     */
    public function make($fileName, $variables)
    {


        if (strstr($fileName, ".")) {


            $fileName = $this->joinDotToUrl($fileName);
        }


        $this->fileName = $fileName;
        $this->params = $variables;

        return $this;
    }

    public function autoload($au = false)
    {

        $this->autoload = $au;
        return $this;
    }

    /**
     *
     * @param array $language
     * @return \Gem\Components\View
     *
     *  [ 'dil' => [
     *   'file1','file2'
     *  ]
     */
    public function language($language)
    {

        if (count($language) > 0 && is_array($language)) {

            foreach ($language as $lang) {

                ## alt par�alama
                foreach ($lang as $langfile) {

                    $file = $this->joinDotToUrl($langfile);
                    $fileName = LANG . $langfile . '/' . $file . ".php";

                    if (file_exists($fileName)) {

                        $newParams = include $fileName;
                        $this->params = array_merge($this->params, $newParams);
                    }
                }
            }
        }


        return $this;
    }

    /**
     * Çıktıyı oluşturur
     * @throws Exception
     */
    public function execute()
    {

        $fileName = $this->viewFilePath($this->fileName);
        $variables = $this->params;


        if ($this->file->exists($fileName)) {

            ## header dosyası yüklenmesi
            if ($this->autoload === true) {

                $file = $this->autoloadGenareteFilePath('inc.header');

                if ($this->file->exists($file)) {

                    $this->file->inc($file, $variables);

                }
            }

            $this->file->inc($fileName, $variables);

            ## footer dosyaı yüklemesi
            if ($this->autoload === true) {

                $fileF = $this->autoloadGenareteFilePath('inc.footer');

                if ($this->file->exists($fileF)) {

                    $this->file->inc($fileF, $variables);
                }
            }
        } else {

            throw new Exception(sprintf("%s dosyasi bulunamadi", $fileName));
        }
    }

    /**
     *
     * @param string $path
     * @return string
     */
    private function viewFilePath($path)
    {

        return $path . '.php';
    }

    /**
     *
     * @param string $path
     * @return string
     * @access private
     */
    private function autoloadGenareteFilePath($path)
    {

        $filePath = $this->joinDotToUrl($path);

        $path = $this->viewFilePath($filePath);

        return $path;
    }

    public function __destruct(){

        unset($this->file);

    }
}
