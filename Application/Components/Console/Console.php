<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Console;

    use Exception;
    use Gem\Components\Helpers\Config;
    use Gem\Components\Support\Accessors;

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
                call_user_func_array([$this, $task], [$bundle, $args]);


            } else {
                throw new Exception('Parametreniz sayınız 1 den küçük olamaz');
            }
        }
    }