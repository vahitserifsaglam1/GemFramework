<?php
    /**
     *  Çağrılabilir Fonksiyon'u çalıştırır
     */
    namespace Gem\Components\Route\Http\Dispatchers;

    class CallableDispatcher extends GeneralDispatcher
    {

        public function __construct(callable $call = null, array $params = [])
        {
            $this->setContent(call_user_func_array($call, $params));
        }
    }
