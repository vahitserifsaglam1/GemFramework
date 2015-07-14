<?php
    /**
     * Created by PhpStorm.
     * User: mrrobot
     * Date: 14.07.2015
     * Time: 11:52
     */

    namespace Gem\Components\Exception;

    use Exception;

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