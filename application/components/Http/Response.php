<?php

/**
 *
 *  Bu Dosya GemFramework'un bir parçasıdır, GemFramework'de Yapılan isteklere gönderilecek cevabı belirler.
 *
 */

namespace Gem\components\Http;

use HttpResponseException;

class Response {

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

        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = array_merge($this->gemFrameworkHeaders, $this->headers);
        $this->headers = array_merge($this->standartHeaders, $this->headers);

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


        http_response_code($this->statusCode);
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


}