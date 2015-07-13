<?php

    /**
     *  GemFramework View S�n�f� -> G�r�nt� dosyalar� �retmek de kullan�l�r

     */

    namespace Gem\Components;

    use Exception;
    use Gem\Components\Debug\Debug;
    use Gem\Components\Patterns\Singleton;
    use Gem\Components\View\ShouldBeView;
    use Gem\Components\View\ViewManager;

    class View extends ViewManager implements ShouldBeView
    {
        use Debug;
        private $file;

        public function __construct()
        {

            parent::__construct();
            $this->file = Singleton::make('Gem\Components\Filesystem');
            $this->debugBoot();
        }



        /**
         * Görüntü dosyasını kullanıma hazırlar
         *
         * @param string $fileName
         * @param array  $variables
         * @throws Exception
         * @return $this
         */
        public static function make($fileName = '', $variables = [])
        {
            $app = new static();
            $app->setFileName($fileName);
            $app->setParams($variables);

            return $app;
        }


        /**
         * Çıktıyı oluşturur
         *
         * @throws Exception
         */
        public function execute()
        {

            $fileName = $this->fileName;
            $variables = $this->params;

            $this->debug['params'] = $this->params;
            $this->debug['files'][] = $fileName;

            if (true === $this->autoload) {

                $this->loadHeaderFiles();
            }

            $this->loadFile($fileName, $variables);

            if (true === $this->autoload) {

                $this->loadFooterFiles();
            }

            return ob_get_clean();
        }


        /**
         * Girilen dosyayı yüklemeye çalışır
         *
         * @param string $file
         * @param array  $params
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
         *
         * @return bool
         */
        private function loadHeaderFiles()
        {

            $params = $this->params;
            $files = $this->headerBag->getViewHeaders();
            foreach ($files as $file) {
                $this->debug['files'][] = $file;
                $this->loadFile($file, $params);
            }

            return true;
        }

        /**
         * Header dosyasını yükler
         *
         * @return bool
         */
        private function loadFooterFiles()
        {

            $params = $this->params;
            $files = $this->footerBag->getViewFooters();

            foreach ($files as $file) {
                $this->debug['files'][] = $file;
                $this->loadFile($file, $params);
            }

            return true;
        }
    }
