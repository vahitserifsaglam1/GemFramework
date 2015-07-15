<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Installation;

    /**
     * Class AllConfigsLoader
     * @package Gem\Components\Installation
     */
    use Gem\Components\Application;
    use Gem\Components\Config\Reposity;
    use Gem\Components\Patterns\Singleton;
    use Symfony\Component\Finder\Finder;
    use Symfony\Component\Finder\SplFileInfo;
    use Exception;

    class AllConfigsLoader
    {

        /**
         * Başlatıcı fonksiyon
         * @params Application $app
         */
        public function __construct(Application $app = null)
        {

            if (null !== $app) {
                if (file_exists($app->getCachedConfig())) {
                    $items = require $items;
                }
            }

            $files = $this->getAllConfigFiles();
            if (is_array($files)) {
                if (count($files) > 0) {
                    $items = $this->loadConfigItems($files);
                }
            }

            $class = Singleton::make('Gem\Components\Config\Reposity', [$items]);
            date_default_timezone_set($class['general.application.timezone']);
        }

        /**
         * Tüm Config Dosylarını döndürür
         * @return array
         */
        public function getAllConfigFiles()
        {
            $finded = Finder::create()->files()->name('*.php')->in(CONFIG_PATH);

            foreach ($finded as $find) {
                if ($find instanceof SplFileInfo) {
                    $files[first(explode('.', $find->getFilename()))] = $find->getRealPath();
                }
            }

            return $files;
        }

        /**
         * Dosyaları Yükler
         * @throws Exception
         * @param array $files
         * @return array
         */
        private function loadConfigItems(array $files = [])
        {

            $configs = [];
            foreach ($files as $name => $path) {

                if (file_exists($path)) {
                    $return = include $path;
                    if (is_array($return)) {
                        $configs[$name] = $return;
                    } else {
                        throw new Exception(sprintf('%s ayar dosyasında herhangi bir değer döndürülmemiş veya yanlış ayar döndürüldü',
                            $path));
                    }
                }

            }

            return $configs;
        }

    }