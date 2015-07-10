<?php

    namespace Gem\Components\Route;

    use Gem\Components\App;
    use Gem\Components\Job\JobDispatcherInterface;
    use Gem\Components\Support\MethodDispatcher;

    /**
     * Bu sınıf GemFramework Controller dosyasında extend üzere yapılmıştır.
     * Class Controller
     *
     * @package Gem\Components\Route
     */
    abstract class Controller
    {
        use MethodDispatcher;
        protected $model;
        protected $job;
        protected $response;

        /**
         * Girilen model ismine göre Model'i çağırır
         *
         * @param string $modelName Kullanılacak olan Model'in ismi
         * @return mixed
         */
        public function model($modelName = '')
        {
            $this->model = App::uses($modelName, App::MODEL);

            return $this->model;
        }

        /**
         * Response Objesini atar
         *
         * @param ShouldBeResponseInterface $response
         * @return $this
         */
        public function response(ShouldBeResponseInterface $response)
        {
            $this->response = $response;

            return $this;
        }

        /**
         * @return Gem\Components\Http\Response
         */
        public function getResponse()
        {
            return $this->response;
        }

        /**
         * Sınıfın yapacağı işleri ayar
         *
         * @param JobDispatcherInterface $job Yapılacak işlerin toplandığı sınıf 'a ait instance
         * @return $this
         */
        public function job(JobDispatcherInterface $job)
        {
            $this->job = $job;
            $this->getJob();

            return $this;
        }

        /**
         * JobManager objesini döndürür
         *
         * @return JobDispatcherInterface
         */
        protected function getJob()
        {
            return $this->job;
        }

        /**
         * @param null $name
         * @param null $value
         * @return $this
         */
        public function __set($name = null, $value = null)
        {
            $this->job->$name = $value;

            return $this;
        }

        /**
         * JobManager'i yürütür
         *
         * @return mixed
         */
        protected function run()
        {
            return $this->getJob()->dispatch();
        }

        public function __call($name, $params)
        {
            return call_user_func_array([$this->getJob(), $name], $params);
        }
    }
