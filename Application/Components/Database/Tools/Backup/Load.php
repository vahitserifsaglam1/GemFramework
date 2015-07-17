<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Database\Tools\Backup;

    use Gem\Components\Database\Base;
    use Gem\Components\Database\Builders\BuildManager;
    use Gem\Components\Filesystem;
    use Symfony\Component\Finder\Finder;
    use Gem\Components\Database\Mode\Insert;
    use Symfony\Component\Finder\SplFileInfo;

    class Load extends BuildManager
    {

        /**
         * Filesystem e ait bir örnek
         *
         * @var Filesystem
         */
        private $file;

        /**
         * @var Base
         */
        private $base;

        /**
         * @param Base|null $base
         */

        public function __construct(Base $base = null)
        {
            parent::__construct($base);
            $this->file = Filesystem::getInstance();
            $this->base = $base;
        }

        /**
         * Girilen dosyayı yürütür
         * @param string $name
         * @return array
         */
        public function get($name = '')
        {
            $return = [];
            if ('' !== $name) {
                $return[] = $this->execute($name);
            } else {

                $list = $this->listBackupDir();

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

            $file = $this->generatePath($name);
            if ($this->file->exists($file)) {
                if ($this->file->isReadable($file)) {
                    $content = $this->file->read($file);
                    $content = json_decode($content, true);
                    foreach ($content as $arg) {
                        $createTable = $arg['createTable'];
                        $params = $arg['params'];
                        $content = $arg['content'];
                        $table = $arg['table'];
                        // query i çalıştırıyoruz
                        if ($this->firstStepQueryContent($content)) {

                            // tablo yapısını oluşturuyoruz
                            if ($this->againCreateTableQuery($createTable)) {

                                $insert = $this->base->insert($table, function (Insert $mode) use ($params) {
                                    return $mode->set($params)->run();
                                });
                                if ($insert) {
                                    return true;
                                }

                            }

                        }

                    }

                }
            }

            return false;
        }

        /**
         * İlk adımda içeriği yükler
         *
         * @param string $content
         * @return \PDOStatement|bool
         */
        private function firstStepQueryContent($content = '')
        {
            $this->setQuery($content);
            $this->run(true);

            return true;
        }

        /**
         * Klasörün içeriğini döndürür
         *
         * @return Finder
         */
        private function listBackupDir()
        {
            return Finder::create()->files()->name('*.backup')->in(DATABASE . 'Backup/');
        }

        /**
         * Tablo yapısını oluşturur
         *
         * @param $createTable
         * @return \PDOStatement|bool
         */
        private function againCreateTableQuery($createTable)
        {
            $this->setQuery($createTable);
            return $this->run(true);
        }


        /**
         * $name 'e girilen isme göre dosyayı siler, eğer boş girilirse dosyayı temizler
         *
         * @param string $name
         * @return array
         */
        public function forget($name = '')
        {
            $return = [];

            if ('' === $name) {
                $path = $this->generatePath($name);

                if ($this->file->exists($path)) {
                    $return[] = $this->file->delete($path);
                } else {
                    $return[] = false;
                }
            } else {
                $list = $this->listBackupDir();

                foreach ($list as $file) {
                    if ($file instanceof SplFileInfo) {
                        $return[] = $this->file->delete($file->getRealPath());
                    }
                }

                return $return;
            }

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