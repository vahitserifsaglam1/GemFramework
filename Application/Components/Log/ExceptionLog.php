<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Log;

    use Exception;

    class ExceptionLog extends Log
    {

        private $exception;

        public function __construct(Exception $exception = null)
        {
            $this->exception = $exception;
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
            $string = sprintf("[%s], İstisna => { Mesaj: '%s', Dosya : '%s', Satır: %d, Hata Kodu: %d } \n", $time,
                $this->exception->getMessage(),
                $this->exception->getFile(),
                $this->exception->getLine(),
                $this->exception->getCode());
            return $string;
        }

    }