<?php

    /**
     * Bu sınıf gem framework de bazı işlemler yapılması için tasarlanmıştır
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     */
    namespace Gem\Components\Job;
    use Gem\Components\Support\MethodDispatcher;
    use Gem\Components\Support\SetCollector;

    /**
     * Class JobManager
     *
     * @package Gem\Components\Job
     */

    class JobManager implements ShouldBeJob
    {
        use SetCollector, MethodDispatcher;
        private $callback;

        /**
         *  Başlatıcı fonksiyon
         */
        public function __construct()
        {
            parent::__construct();
        }

        /**
         * Ekstra olarak fonksiyon eklemek
         *
         * @param callable $callback
         * @return $this
         */
        public function doIt(callable $callback = null)
        {
            $this->callback = $callback;
            return $this;
        }

        /**
         * Veriyi işler
         *
         * @return mixed
         */
        public function dispatch()
        {
            $params = $this->getCollectedParameters();
            return call_user_func_array([$this, $this->callback], $params = []);
        }
    }
