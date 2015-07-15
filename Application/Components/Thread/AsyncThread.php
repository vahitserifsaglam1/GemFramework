<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Thread;

    use Thread;
    use Exception;

    /**
     * Class AsyncThread
     * @package Gem\Components\Thread
     */
    class AsyncThread extends Thread
    {

        /**
         * @var callable|null
         */
        private $job = null;

        /**
         * @var array
         */
        private $params = [];

        /**
         * @param callable|null $job
         * @return $this
         */
        public function setJob(callable $job = null)
        {
            $this->job = $job;
            return $this;
        }

        /**
         * Parametreleri atar
         * @param array $params
         * @return $this
         */
        public function setParams(array $params = [])
        {

            $this->params = $params;
            return $this;
        }

        /**
         * Parametreleri döndürür
         * @return array
         */
        public function getParams()
        {
            return $this->params;
        }

        /**
         * Olayı döndürür
         * @return callable|null
         */
        public function getJob()
        {
            return $this->job;
        }

        /**
         * @param callable|null $job
         */
        public function __construct(callable $job = null, $params = [])
        {
            $this->setJob($job);
            $this->start();
        }


        /**
         * @throws Exception
         * @return mixed
         */
        public function run()
        {

            if (is_callable($this->getJob())) {

                return call_user_func_array($this->getJob(), $this->getParams());
            } else {
                throw new Exception('Girdiğiniz iş bir çağrılabilir fonksiyon değil');
            }
        }

    }