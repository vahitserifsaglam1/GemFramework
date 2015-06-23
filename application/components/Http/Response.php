<?php

/**
 *
 *  Bu Dosya GemFramework'un bir parçasıdır, GemFramework'de Yapılan isteklere gönderilecek cevabı belirler.
 *
 */

namespace Gem\components\Http;

use HttpResponseException;

class Response {

    private $protocolVersion;
    private $statusTexts = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',            // RFC2518
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',          // RFC4918
        208 => 'Already Reported',      // RFC5842
        226 => 'IM Used',               // RFC3229
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Reserved',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',    // RFC7238
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',                                               // RFC2324
        422 => 'Unprocessable Entity',                                        // RFC4918
        423 => 'Locked',                                                      // RFC4918
        424 => 'Failed Dependency',                                           // RFC4918
        425 => 'Reserved for WebDAV advanced collections expired proposal',   // RFC2817
        426 => 'Upgrade Required',                                            // RFC2817
        428 => 'Precondition Required',                                       // RFC6585
        429 => 'Too Many Requests',                                           // RFC6585
        431 => 'Request Header Fields Too Large',                             // RFC6585
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates (Experimental)',                      // RFC2295
        507 => 'Insufficient Storage',                                        // RFC4918
        508 => 'Loop Detected',                                               // RFC5842
        510 => 'Not Extended',                                                // RFC2774
        511 => 'Network Authentication Required',                             // RFC6585
    );
    private $content = '';
    private $statusCode = 200;
    private $gemFrameworkHeaders = [

        'GemFrameworkVersion' => FRAMEWORK_VERSION,
        'GemFrameworkProjectName' => FRAMEWORK_NAME

    ];

    private $standartHeaders = [
        'Content-language' => 'en',
         'X-Powered-By' => 'PHP/'.PHP_VERSION,
    ];

    private $headers = [];

    /**
     * Sınıfı başlatır.
     * @param string $content
     * @param int $statusCode
     */
    public function __construct($content = '', $statusCode = 200){

        $this->setContent($content);
        $this->setStatusCode($statusCode);
        $this->setProtocolVersion('1.1');
        $this->headers = array_merge($this->gemFrameworkHeaders, $this->headers);
        $this->headers = array_merge($this->standartHeaders, $this->headers);

    }

    /**
     * Http Protocol'unun version'unu ayarlar
     * @param string $version
     * @return $this
     */
    public function setProtocolVersion($version = ''){

        $this->protocolVersion = $version;
        return $this;

    }
    /**
     * İçeriği tanımlar
     * @param string $content
     * @return $this
     */

    public function setContent($content = ''){

        $this->content = $content;
        return $this;
    }

    /**
     * Durum Kodunu tanımlar
     * @param int $code
     * @return $this
     */
    public function setStatusCode($code=200){

        $this->statusCode = $code;
        return $this;

    }
    public function header($header = '', $value = null){

        if(is_string($header) && !is_null($value))
        {
            $this->headers[$header] = $value;
        }elseif(is_array($header) && is_null($value)){
            $this->headers = arrray_merge($this->headers, $header);
        }

        return $this;

    }

    private function runHeaders(){

        header('Content-Type: text/html; charset=utf-8');
        foreach($this->headers as $header => $value){


            header($this->genareteHeaderString($header, $value));

        }

    }

    private function genareteHeaderString($key, $value = ''){


        return "$key: $value;";

    }

    /**
     * Çıktıyı Gönderiri
     * @throws HttpResponseException
     */

    public function execute(){


        $code = $this->statusCode;
        if(isset($this->statusTexts[$code]))
            $text = $this->statusTexts[$code];
        else
            $text = '';
        header($this->protocolVersion.' '.$code.' '. $text);

        if(!headers_sent()){

            $this->runHeaders();
            echo $this->content;

        }else{

            throw new HttpResponseException('Başlıklar  zaten gönderilimiş, bu işlem gerçekleştirilemez');

        }


    }

    /**
     * Sayfayı 404 yapar.
     * @return $this
     *
     */
    public function setPage404(){

        $this->statusCode = 404;
        return $this;

    }

    /**
     * Yeni bir response objesi oluşturur
     * @param string $content
     * @param int $statusCode
     * @return static
     */
    public static function make($content = '', $statusCode = 200){

        return new static($content, $statusCode);

    }
}
