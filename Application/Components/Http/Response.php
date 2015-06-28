<?php

/**
 *
 *  Bu Dosya GemFramework'un bir parçasıdır, GemFramework'de Yapılan isteklere gönderilecek cevabı belirler.
 *
 */

namespace Gem\components\Http;

use HttpResponseException;
use Gem\Components\View;
use Gem\Components\Twig;
use Gem\Components\Http\Response\ShouldBeResponse;
use Gem\Components\Http\JsonResponse;
use Gem\Components\View\ShouldBeView;
use Gem\Components\Patterns\Singleton;
use Gem\Components\Cookie;
class Response implements ShouldBeResponse{

    private $contentType = 'text/html';
    private $protocolVersion;
    private $charset = 'utf-8';
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
        'Content-Language' => 'en',
         'X-Powered-By' => 'PHP/'.PHP_VERSION,
    ];

    private $headersBag;
    private $cookie;

    /**
     * Sınıfı başlatır.
     * @param string $content
     * @param int $statusCode
     */
    public function __construct($content = '', $statusCode = 200){

        $this->setContent($content);
        $this->setStatusCode($statusCode);
        $this->setProtocolVersion('1.1');
        $this->headersBag = Singleton::make('Gem\Components\Http\Response\HeadersBag');
        $this->headersBag->headers = array_merge($this->gemFrameworkHeaders, $this->headersBag->headers);
        $this->headersBag->headers = array_merge($this->standartHeaders, $this->headersBag->headers);
        $this->cookieBag =  new Cookie();

    }

    /**
     * Cookie Ataması yapar
     * @param CookieJar $cookieJar
     * @return $this
     */
    public function setCookie(CookieJar $cookieJar)
    {

        $this->headersBag->setCookie($cookieJar);
        return $this;
    }

    /**
     * Charset'i döndürür
     * @return string
     */
    public function getCharset(){

        return $this->charset;

    }


    /**
     * Cookileri döndürür
     * @return array
     */
    public function getCookies(){

        return $this->cookie->cookies;

    }

    /**
     * @param string $type
     * @return $this
     */
    public function setContentType($type = ''){

        $this->contentType = $type;
        return $this;

    }

    /**
     * @return string
     */
    public function getContentType(){

        return $this->contentType;

    }

    /**
     * Charset ataması yapar
     * @param string $charset
     * @return $this
     */

    public function setCharset($charset = 'utf-8'){

        $this->charset = $charset;
        return $this;

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


        if($content instanceof ShouldBeView){
            $content = $content->execute();
        }

        $this->content = $content;
        return $this;
    }


    public function jsonResponse($content = '', $statusCode = 200){


        return new JsonResponse($content,$statusCode);

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


    private function generateHeaderString($key, $value = ''){


        return sprintf("%s: %s", settype($key,"string"), settype($key, "string"));

    }

    /**
     * Headerları atar
     */

    private function runHeaders(){

        header(
          sprintf("Content-Type: %s; charset=%s", $this->getContentType(), $this->getCharset())
        );
        foreach($this->headersBag->getHeaders() as $header => $value){

            header($this->generateHeaderString($header, $value));

        }

    }

    /**
     *
     * Cookieleri atar
     *
     */
    private function useCookies(){

        $cookies = $this->headersBag->getCookies();

        foreach($cookies as $cookie){

            header(sprintf("Set-Cookies:%s", $cookie));

        }
    }

    /**
     *
     * Protocol version ve code atamasını yapar
     *
     */
    private function setProtocolAndCode()
    {

        $code = $this->statusCode;
        if(isset($this->statusTexts[$code]))
            $text = $this->statusTexts[$code];
        else
            $text = '';
        header(sprintf("%s %d %s ", $this->protocolVersion, $code, $text));
    }
    /**
     * Çıktıyı Gönderiri
     * @throws HttpResponseException
     */

    public function execute(){

        $this->setProtocolAndCode();
        $this->useCookies();
        if(!headers_sent()){

            $this->runHeaders();
            echo $this->content;

        }else{

            throw new HttpResponseException(
                'Başlıklar  zaten gönderilimiş, bu işlem gerçekleştirilemez'
            );

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
     * yeni bir view objesi döndürür
     * @param $fileName
     * @param array $params
     * @return $this
     */
    public function view($fileName, $params = []){

        return View::make($fileName, $params);

    }

    /**
     * Twig objesi döndürür
     * @param $fileName
     * @param array $params
     * @return $this
     */
    public function twig($fileName, $params = []){

        return Twig::make($fileName, $params);

    }

    /**
     * Yeni bir response objesi oluşturur
     * @param string $content
     * @param int $statusCode
     * @return static
     */
    public function make($content = '', $statusCode = 200){

        return new static($content, $statusCode);

    }

    /**
     * Dinamik olarak method çağrımı
     * @param $name
     * @param $params
     * @return mixed
     */
    public function __call($name, $params){

        if(is_callable([$this->headersBag, $name])){

            return call_user_func_array([$this->headersBag, $name], $params);

        }

    }
}
