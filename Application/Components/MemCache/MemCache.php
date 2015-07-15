<?php
    namespace Gem\Components\MemCache;

    use Gem\Components\Helpers\Config;
    use Exception;
    use Memcache as MemCacheBag;

    class MemCache
    {
        private $memCache;

        public function __construct()
        {
            $this->checkDriver();
            list($host, $port) = array_values(Config::get('stroge.memcache'));
            $this->memCache = new MemCacheBag();
            $this->memCache->connect($host, $port);
        }

        public function getMemCache()
        {
            return $this->memCache;
        }

        /**
         * Sürücünün kurulu olup olmadığını kontrol eder
         * @throws Exception
         */
        private function checkDriver()
        {
            if (!extension_loaded('memcache')) {
                throw new Exception('Memcache Eklentiniz Kurulmamış');
            }
        }

        /**
         * @param string $method
         * @param array $params
         * @return mixed
         * @throws Exception
         */
        public function __call($method = '', array $params = [])
        {
            if (is_callable([$this->getMemCache(), $method]) || method_exists($this->getMemCache(), $method)) {
                return call_user_func_array([$this->getMemCache(), $method], $params);
            } else {
                throw new Exception(sprintf('%s adında bir method bulunamadı', $method));
            }
        }
    }