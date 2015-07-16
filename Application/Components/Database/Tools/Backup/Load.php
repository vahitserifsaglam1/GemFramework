<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Database\Tools\Backup;

    use Gem\Components\Database\Base;
    use Gem\Components\Database\Builders\BuildManager;
    use Gem\Components\Filesystem;
    use Symfony\Component\Finder\Finder;

    class Load extends BuildManager
    {

        /**
         * Veritabanının ana dosyası
         *
         * @var Base
         */
        private $base;

        /**
         * Filesystem e ait bir örnek
         *
         * @var Filesystem
         */
        private $file;

        public function __construct(Base $base = null)
        {
            $this->file = Filesystem::getInstance();
            $this->base = $base;
        }

        /**
         * Girilen dosyayı yürütür
         * @param string $name
         * @return array
         */
        public function run($name = '')
        {
            $return = [];
            if ('' === $name) {
                $return[] = $this->execute($name);
            } else {

                $list = Finder::create()->files()->name('*.backup')->in(DATABASE . 'Backup/');

                foreach ($list as $file) {
                    if ($file instanceof \SplFileInfo) {
                        $return[] = $this->execute(first(explode('.', $file->getFilename())));
                    }
                }
            }

            return $return;
        }


        /**
         * @param string $name
         * @return array
         */
        public function execute($name = '')
        {
            $return = [];

            $file = $this->generatePath($name);
            if ($this->file->exists($file)) {
                if ($this->file->isReadable($file)) {
                    $content = $this->file->read($file);
                    $content = json_encode($content, true);

                    var_dump($content);
                }
            }

            return $return;

        }


        /**
         * Backup dosyasının yolunu oluşturur
         *
         * @param string $nane
         * @return string
         */
        private function generatePath($nane = '')
        {
            return DATABASE . 'Backup/' . $nane . '.php';
        }
    }