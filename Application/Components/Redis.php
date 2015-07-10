<?php

    namespace Gem\Components;

    use Gem\Components\Redis\RedisConnector;

    class Redis extends RedisConnector
    {

        /**
         * Sınıfı başlatır ve Ebeveyn sınıfının da başlatılmasını sağlar
         *
         * @throws \Exception
         */
        public function __construct()
        {
            parent::__construct();
        }
    }
