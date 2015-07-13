<?php
    namespace Gem\Components\Http\Response;
    use Exception;
    class HttpResponseException extends Exception
    {
        public function __construct($message = '')
        {
            $this->message = $message;
        }
    }