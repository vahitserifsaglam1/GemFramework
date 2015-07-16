<?php

    namespace Gem\Components\View;

    use Gem\Components\Helpers\Config;
    use Gem\Components\Helpers\String\Builder;
    use Gem\Components\Helpers\String\Parser;
    use Exception;

    /**
     * Bu sınıf GemFramework'deki view sınıflarını bağlar.
     * Class Connector
     *
     * @package Gem\Components\Vıew
     */
    class ViewManager
    {

        use Parser, Builder;

        /**
         * Autoload ın yapılıp yapılmayacağını kontrol eder
         *
         * @var bool
         */
        protected $autoload;
        protected $fileName;
        protected $params;
        protected $headerBag;
        protected $footerBag;
        protected $debug;

        /**
         * Sınıfı başlatır ve gerekli ayarlamaları yapar
         *
         */

        public function __construct()
        {
            $this->headerBag = new HeaderBag();
            $this->footerBag = new FooterBag();
            $view = Config::get('general.view');
            $this->headerFile($view['headerFiles']);
            $this->footerFile($view['footerFiles']);
        }

        /**
         * Autoload yapılıp yapılmayacağını kontrol eder
         *
         * @param bool $au
         * @return $this
         */
        public function autoload($au = false)
        {

            $this->autoload = $au;

            return $this;
        }

        /**
         * @param string $file
         * @return string
         */
        protected function in($file = '')
        {

            return VIEW . $file . '.php';
        }

        /**
         * Header dosyalarının atamasını yapar
         *
         * @param array $file
         * @return $this
         */
        public function headerFile(array $file = [])
        {

            $this->headerBag->setViewHeaders($file);
            return $this;
        }

        public function footerFile(array $file = [])
        {

            $this->footerBag->setViewFooters($file);

            return $this;
        }

        /**
         * @param array $language
         * @return \Gem\Components\View
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
         * Dosya  adını atar
         *
         * @param string $fileName
         * @return $this
         */
        public function setFileName($fileName = '')
        {
            $this->fileName = $fileName;

            return $this;
        }

        /**
         * Kullanılacak parametreleri atar
         *
         * @param array $params
         * @return $this
         */
        public function setParams($params = [])
        {
            $this->params = $params;

            return $this;
        }

        /**
         * Yeni bir parametre ekler
         * @param string $key
         * @param mixed $value
         * @throws Exception
         * @return $this
         */
        public function with($key = '', $value)
        {
            if (!is_string($key)) {
                throw new Exception('Girdiğiniz key değeri geçerli bir değer değil');
            }
            $this->params[$key] = $value;
        }
        /**
         * View Dosyasının olup olmadığını kontrol eder
         * @param string $fileName
         * @return bool
         */

        public function exists($fileName = '')
        {
            if(file_exists($this->in($fileName)))
            {
                return true;
            }else{
                return false;
            }
        }
    }
