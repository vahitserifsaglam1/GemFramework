<?php

namespace Gem\Components\Http;

use Gem\Components\Http\RequestHeadersBag;
class ServerBag extends RequestHeadersBag{

    /**
     *
     * Server Değişkenindeki Http headerleri atar.
     *
     */
    public function __construct(){

        $headers = [];
        foreach ($this->getServer() as $name => $value)
        {
            if (substr($name, 0, 5) == 'HTTP_')
            {
                $name = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
                $headers[$name] = $value;
            } else if ($name == "CONTENT_TYPE") {
                $headers["Content-Type"] = $value;
            } else if ($name == "CONTENT_LENGTH") {
                $headers["Content-Length"] = $value;
            }
        }

        $this->headers = array_merge($this->headers, $headers);

    }



}