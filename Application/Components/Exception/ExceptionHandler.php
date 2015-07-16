<?php
    /**
     *  Bu Sınıf GemFramework'de oluşan Exception Hatalarını yakalaması için Oluşturulmuştur.
     *
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     */
    namespace Gem\Components\Exception;

    use Exception;
    use Gem\Components\Helpers\Config;
    use Gem\Components\Support\Migrate;
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

            // dinleyici varsa dinleyiciyi çalıştırır
            if ($callback = Config::has('app.log.exception')) {
                $callback($exception);
            }

            // içeriği atar
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

            response(Migrate::make('stroge/error/exception.php',
                compact('message', 'line', 'code', 'prev', 'file', 'trace')))->execute();
        }

    }