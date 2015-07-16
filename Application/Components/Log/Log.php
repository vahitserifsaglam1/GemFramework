<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Log;

    use Gem\Components\Filesystem;

    /**
     * Bu sınıf ile log dosyalarını kaydedilmesi yaplır.
     * Class Log
     * @package Gem\Components\Log
     */
    class Log extends Filesystem
    {

        /**
         * @var string
         */
        private $logFile;

        /**
         * @param string $logFile
         */
        public function __construct($logFile = '')
        {
            $this->setLogFile($logFile);
        }


        /**
         * @param string $logFile
         * @return $this
         */
        public function setLogFile($logFile)
        {
            $this->logFile = $logFile;
            return $this;
        }

        /**
         * @return string
         */
        public function getLogFile()
        {
            return $this->logFile;;
        }

        /**
         * İçeriği log a yazar
         * @param string $logString
         * @return $this
         */
        protected function writeToLog($logString = '')
        {
            if (!$this->exists($this->getLogFile())) {
                $this->touch($this->getLogFile());
            }

            $this->write($this->getLogFile(), $logString, true);
            return $this;
        }

    }