<?php
/**
 *
 *  Çağrılabilir Fonksiyon'u çalıştırır
 */
namespace Gem\Components\Route\Http\Dispatchers;
use Gem\Components\Route\Http\Dispatchers\GeneralDispatcher;
class CallableDispatcher extends GeneralDispatcher {

    public function __construct(callable $call = null, array $params = [])
    {

        parent::__construct();
        $params[] = $this->getResponse();
        $this->setContent(call_user_func_array($call, $params));

    }


}