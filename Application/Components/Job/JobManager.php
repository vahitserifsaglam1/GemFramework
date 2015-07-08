<?php
	 namespace Gem\Components\Job;
	 use Gem\Components\Orm\Orm;
     use Gem\Components\Support\SetCollector;
     class JobManager extends Orm implements ShouldBeJob
	 {
         use SetCollector;
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
          * @return mixed
          */
         public function dispatch()
         {
             $params = $this->getCollectedParameters();
             $params[] = $this;
             return call_user_func_array([$this, $this->callback], $params = []);
         }
	 }
