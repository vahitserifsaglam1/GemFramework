<?php
    namespace Gem\Components\MemCache;

    use Gem\Components\Cache\CacheDriverInterface;
    use Gem\Components\Cache\CacheInterface;
    use Gem\Components\Helpers\Config;
    use Exception;
    use Memcache as MemCacheBag;

    class MemCache implements CacheInterface, CacheDriverInterface
    {

        /**
         * Memcache objesini tutar
         *
         * @var MemCacheBag
         */
        private $memCache;


        /**
         * Driver ismini alır
         *
         * @var string
         */
        private $name = 'memcache';

        /**
         * Sınıfı başlatır ve işlemleri gerçekleştirir
         *
         * @throws Exception
         */
        public function __construct()
        {
            $this->checkDriver();
            list($host, $port) = array_values(Config::get('stroge.memcache'));
            $this->memCache = new MemCacheBag();
            $this->memCache->connect($host, $port);
        }

        /**
         * Memcache Objesini döndürür
         *
         * @return MemCacheBag
         */
        public function getMemCache()
        {
            return $this->memCache;
        }

        /**
         * Sürücünün kurulu olup olmadığını kontrol eder
         * @throws Exception
         */
        public function checkDriver()
        {
            return extension_loaded('memcache');
        }

        /**
         * Sürücünün adını döndürür
         *
         * @return string
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * $name ile girilen veriyi çeker
         *
         * @param string $name
         * @return array|string
         */
        public function get($name = '')
        {
            return $this->memCache->get($name);
        }

        /**
         * Redis 'e veri ataması yapar
         *
         * @param $name
         * @param string $value
         * @param int $time
         * @return $this
         */
        public function set($name, $value = '', $time = 3600)
        {
            $this->memCache->set($name, $value, $time);
            return $this;
        }

        /**
         * Veri varsa veriyi yoksa false döndürür
         *
         * @param string $name
         * @return array|bool|string
         */
        public function has($name = '')
        {
            if ($has = $this->get($name)) {
                return $has;
            } else {
                return false;
            }
        }

        /**
         * Veriyi Önbellekden siler
         *
         * @param string $name
         * @return $this
         */
        public function delete($name = '')
        {
            $this->memCache->delete($name);
            return $this;
        }

        /**
         * Tüm önbellek verilerini siler
         *
         * @return $this
         */
        public function flush()
        {
            $this->memCache->flush();
            return $this;
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