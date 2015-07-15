<?php
    /**
     *  Bu Sınıf GemFramework'de oluşan Exception Hatalarını yakalaması için Oluşturulmuştur.
     *
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     */
    namespace Gem\Components\Exception;

    use Exception;

    /**
     * Class Handler
     *
     * @package Gem\Components\Exception
     */
    class ExceptionHandler
    {
        /**
         * @var Exception
         */
        private $exception;

        /**
         * Bu Fonksiyon Üzerinde Oluşan Exception Hataları yakalanır
         *
         * @param Exception $exception
         * @return bool
         */

        public function handleException(Exception $exception = null)
        {
            $this->exception = $exception;
            $this->setContentToView();

            return true;
        }

        /**
         * Ekrana Mesajı Bastırır
         */
        private function setContentToView()
        {
            $message = $this->exception->getMessage();
            $line = $this->exception->getLine();
            $code = $this->exception->getCode();
            $prev = $this->exception->getPrevious();
            $file = $this->exception->getFile();
            $trace = $this->exception->getTraceAsString();

            response(twig('Errors/Exception', compact('message', 'line', 'code', 'prev', 'file', 'trace')))->execute();
        }

    }