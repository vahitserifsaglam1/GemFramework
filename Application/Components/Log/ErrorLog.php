<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Log;

    class ErrorLog extends Log
    {

        private $errorNo;
        private $errorMessage;
        private $errorFile;
        private $errorLine;

        public function __construct($errno, $errstr, $errfile, $errli)
        {
            $this->errorNo = $errno;
            $this->errorMessage = $errstr;
            $this->errorFile = $errfile;
            $this->errorLine = $errli;

            parent::__construct('stroge/log/error.log');

            // hata mesajını yazdırıyoruz
            $this->writeToLog($this->getErrorString());
        }

        /**
         * Dinamik olarak oluşturma
         * @return string
         */

        private function getErrorString()
        {
            $string = '';
            $time = date('D, d-M-Y H:i:s T');
            $string = sprintf("[%s], Hata => { Mesaj: '%s', Dosya : '%s', Satır: %d, Hata Kodu: %d } \n", $time,
                $this->errorMessage,
                $this->errorFile,
                $this->errorLine,
                $this->errorNo);
            return $string;
        }

    }