<?php

    /**
     *  Bu sistem Autoload tarafından yürütülebilmesi için oluşturulmuştur.
     *  Sınıfın başlaması için gerekli olan işlemleri yapar.
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     */
    namespace Gem\System;

    use Gem\Components\Application;

    /**
     * Class Run
     * @package Gem\System
     */
    class Run
    {

        private $applicaton;
        /**
         * Sistemi yürütür.
         * @throws \Exception
         */
        public function __construct()
        {

            $this->runBootstrap();
            include APP . 'Helpers/helpers.php';
            $this->application = new Application('GemFramework2Build', 1);
            include SYSTEM . 'Start.php';

            /**
             *
             *  Rotalama olayının Application/routes.php den devam edeceğini bildirir.
             *  İstenilirse -> run ( den önce istenilen işlemler yapılabilir.
             *
             */
            $this->application->run();

        }

        /**
         *  Ayar dosyalarını yükler
         */
        private function runBootstrap()
        {
            include 'System/Bootstrap/bootstrap.php';
        }
    }
