<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Console;


    use Gem\Components\Support\Accessors;

    /**
     * Class Console
     * @package Gem\Components\Console
     */
    class Console extends CommandsManager
    {

        use Accessors;
        private $argc;
        private $args;


        /**
         * @param array $args Komut elemanları
         * @param int $argc Komut sayısı
         */

        public function __construct(array $args = [], $argc = 0)
        {

            $this->setArgs($args);
            $this->setArgc($argc);
        }


        /**
         * Komutları alır, parçalar ve çıktıyı oluşturur
         * @return bool
         */
        public function run()
        {


        }

    }