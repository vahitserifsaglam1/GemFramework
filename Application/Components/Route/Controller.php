<?php

	 namespace Gem\Components\Route;

	 use Gem\Components\App;
	 use Gem\Components\Job\JobManager;
	 use Gem\Components\Support\MethodDispatcher;

	 /**
	  * Bu sınıf GemFramework Controller dosyasında extend üzere yapılmıştır.
	  * Class Controller
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
			* @param string $modelName Kullanılacak olan Model'in ismi
			* @return mixed
			*/
		  public function model ($modelName = '')
		  {
				$this->model = App::uses ($modelName, App::MODEL);

				return $this->model;

		  }

		  /**
			* Response Objesini atar
			* @param ShouldBeResponseInterface $response
			* @return $this
			*/
		  public function response (ShouldBeResponseInterface $response)
		  {
				$this->response = $response;

				return $this;
		  }

		  /**
			* @return Gem\Components\Http\Response
			*/
		  public function getResponse ()
		  {
				return $this->response;
		  }

		  /**
			* Sınıfın yapacağı işleri ayar
			* @param JobManager $job Yapılacak işlerin toplandığı sınıf 'a ait instance
			* @return $this
			*/
		  public function job (JobManager $job)
		  {
				$this->job = $job;

				return $this;
		  }

		  /**
			* JobManager objesini döndürür
			* @return mixed
			*/
		  protected function getJob ()
		  {
				return $this->job;
		  }
	 }
