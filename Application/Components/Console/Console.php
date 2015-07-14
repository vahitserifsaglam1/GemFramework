<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Console;

    use Exception;
    use Gem\Components\Helpers\Config;
    use Gem\Components\Support\Accessors;
    use Gem\Components\Console\Bundle\ConsoleBundle;

    /**
     * Class Console
     * @package Gem\Components\Console
     */
    class Console extends CommandsManager
    {

        use Accessors, Config;
        private $argc;
        private $args;
        private $config;
        /**
         * @param array $args Komut elemanları
         * @param int $argc Komut sayısı
         */

        public function __construct(array $args = [], $argc = 0)
        {
            $this->config = $this->getConfig('console');
            $this->setArgs($args);
            $this->setArgc($argc);
        }


        /**
         * Komutları alır, parçalar ve çıktıyı oluşturur
         * @throws Exception
         * @return bool
         */
        public function run()
        {

            $parser = $this->config['delimeter'];
            if (count($this->getArgs()) > 1) {
                $args = $this->getArgs();
                $fcommand = first($args);

                if (strstr($fcommand, $parser)) {
                    list($task, $bundle) = explode($parser, $fcommand);
                    unset($args[0]);
                } else {
                    list($task, $bundle) = $args;
                    unset($args[0]);
                    unset($args[1]);
                }
                $bundle = mb_convert_case($bundle, MB_CASE_TITLE, 'utf-8');
                $bundle = $this->createBundleName($bundle);
                $bundle = new $bundle();


                // bundle yönetimini yapar
                $this->runBundle($bundle, $task, $args);

            } else {
                throw new Exception('Parametreniz sayınız 1 den küçük olamaz');
            }
        }

        private function runBundle(ConsoleBundle $bundle, $task = '', $args = [])
        {

            if (is_callable([$bundle, $task])) {

            } else {
                throw new Exception(sprintf('%s bundle ında %s adında bir method bulunamadı', get_class($bundle),
                    $task));
            }

        }

        /**
         * Bundle ismini getirir.
         * @param string $bundle
         * @return string
         */
        private function createBundleName($bundle = '')
        {
            return $this->getBundlePrefix() . $bundle;
        }
    }