<?php

    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components;

    use Gem\Components\Helpers\Config;
    use Gem\Components\View\ShouldBeView;
    use Gem\Components\View\ViewManager;
    use Twig_Loader_Filesystem;
    use Twig_Environment;

    /**
     * Class Twig
     * @package Gem\Components
     */

    class Twig extends ViewManager implements ShouldBeView
    {

        /**
         * Ayarlar saklanır
         *
         * @var array
         */

        private $configs;

        /**
         * Twig objesi tutulur
         *
         * @var Twig_Environment
         */
        private $twig;

        /**
         * Sınıf başlatılır ve gerekli ayarlar yapılır
         *
         * @param string $name
         * @param array $parametres
         */

        public function __construct($name = '', $parametres = [])
        {
            parent::__construct();
            $this->setParams($parametres);
            $this->setFileName($name);
            $this->configs = Config::get('twig');
        }

        /**
         * static fonksiyondan yeni bir dinamik oluşturur
         *
         * @param string $name
         * @param array  $parametres
         * @return static
         */

        public static function make($name = '', $parametres = [])
        {
            return new static($name, $parametres);
        }

        /**
         * İçeriği oluşturur
         *
         * @return string
         */
        public function execute()
        {
            $loader = new Twig_Loader_Filesystem(VIEW);
            $this->twig = new Twig_Environment($loader, $this->configs);
            $content = '';

            if (true === $this->autoload) {

                $content .= $this->rendeHeaderFiles();
            }
            $content .= $this->twig->render($this->fileNameGenaretor($this->fileName), $this->params);

            if (true === $this->autoload) {
                $content .= $this->rendeFooterFiles();
            }

            return $content;
        }

        /**
         * Footer dosyalarını getirir
         *
         * @return string
         */
        private function rendeHeaderFiles()
        {
            $params = $this->params;
            $files = $this->headerBag->getViewHeaders();
            $content = '';
            foreach ($files as $file) {
                $content .= $this->twig->render($this->fileNameGenaretor($file), $params);
            }

            return $content;
        }

        /**
         * Footer Dosyalarını getirir
         *
         * @return string
         */
        private function rendeFooterFiles()
        {
            $params = $this->params;
            $files = $this->footerBag->getViewFooters();
            $content = '';
            foreach ($files as $file) {
                $content .= $this->twig->render($this->fileNameGenaretor($file), $params);
            }

            return $content;
        }

        /**
         * Çağrılabilmesi için dosya ismini oluşturur
         *
         * @param string $fileName
         * @return string
         */
        private function fileNameGenaretor($fileName = '')
        {
            return $fileName . '.php';
        }
    }