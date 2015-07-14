<?php
    namespace Gem\Components\Exception;
    use Exception;

    /**
     * Class GemCustomException
     * @package Gem\Components\Exception
     */

    class GemCustomException extends Exception
    {
        /**
         * @param string $message
         * @param int $code
         * @param string $file
         * @param int $line
         */
        public function __construct($message, $code, $file, $line)
        {
            $this->message = $message;
            $this->code = $code;
            $this->file = $file;
            $this->line = $line;
        }
    }