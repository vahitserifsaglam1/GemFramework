<?php
/**
 * Created by PhpStorm.
 * User: vserifsaglam
 * Date: 26.6.2015
 * Time: 05:12
 */

namespace Gem\Components\Route\Http\Dispatchers;
use Gem\Components\Http\Response;
class GeneralDispatcher {

    private $response;
    private $content;
    public function __construct()
    {
        $this->response = new Response();
    }

    public function getResponse()
    {

        return $this->response;

    }

    protected function setContent($content = '')
    {
        $this->content = $content;
    }

    public function getContent()
    {

        return $this->content;

    }
}
