<?php
	 /**
	  * Created by PhpStorm.
	  * User: vserifsaglam
	  * Date: 26.6.2015
	  * Time: 04:43
	  */

	 namespace Gem\Components\Route\Http;

	 use Exception;
	 use Gem\Components\Helpers\Access\Interfaces\HandleInterface;
	 use Gem\Components\Helpers\Access\Interfaces\TerminateInterface;
	 use Gem\Components\Http\Request;
	 use Gem\Components\Http\Response\ShouldBeResponseInterface;
	 use Gem\Components\Route\Http\Dispatchers\CallableDispatcher;
	 use Gem\Components\Route\Http\Dispatchers\ControllerDispatcher;

	 class Dispatch
	 {

		  private $dispatchController;
		  private $dispatchCallable;
		  private $method = null;

		  private $before = null;
		  private $access = null;
		  private $params = null;
		  private $next = null;
		  private $role = null;

		  const CONTROLLER_METHOD = 1;
		  const CALLABLE_METHOD = 2;

		  protected function setRouteControllerForDispatch ($controller = null)
		  {
				$this->method = self::CONTROLLER_METHOD;
				$this->dispatchController = $controller;

		  }

		  /**
			* Route olayında bir callable çağırmak istiyorsanız bunu kullanırsınız
			* @param null $callable
			* @return $this
			*/
		  protected function setRouteCallableForDispatch ($callable = null)
		  {

				$this->method = self::CALLABLE_METHOD;
				$this->dispatchCallable = $callable;


		  }

		  /**
			* @param callable $next
			* @return $this
			*/
		  protected function setNext (callable $next = null)
		  {

				$this->next = $next;

				return $this;

		  }

		  /**
			* Before ataması yapar
			* @param callable $before
			* @return $this
			*/
		  public function setBefore (callable $before = null)
		  {

				$this->before = $before;

				return $this;

		  }

		  /**
			* Access Yöneticisini atar.
			* @param HandleInterface $handler
			* @return $this
			*/
		  public function setAccess (HandleInterface $handler = null)
		  {

				$this->access = $handler;

				return $this;

		  }

		  public function setParams (array $params = [ ])
		  {

				$this->params = $params;

				return $this;

		  }

		  /**
			* Çıktıyı oluşturur
			* @throws Exception
			*/
		  public function dispatch ()
		  {

				$controller = $this->dispatchController;
				$callable = $this->dispatchCallable;
				if ( is_null ($controller) && is_null ($callable) ) {

					 throw new Exception('Herhangi bir Controller veya Callable methodu atamadınız');

				}

				$method = $this->method;

				if ( $this->beforeChecker () && $this->accessChecker () ) {

					 switch ( $method ) {

						  case self::CALLABLE_METHOD:
								$this->response ($this->callableDispatcher ());
								break;
						  case self::CONTROLLER_METHOD:
								$this->response ($this->controllerDispatcher ());
								break;
						  default:
								throw new Exception('Geçersiz bir yapı girdiniz');
								break;
					 }

				}

		  }

		  public function getParams ()
		  {

				return $this->params;

		  }

		  /**
			* @param null $role
			* @return $this
			*/

		  protected function setRole ($role = null)
		  {
				$this->role = $role;

				return $this;
		  }

		  /**
			* Çağrılabilir fonksiyonu çalıştırır
			* @return mixed
			*/
		  private function callableDispatcher ()
		  {

				return (new CallableDispatcher($this->dispatchCallable, $this->getParams ()))->getContent ();
		  }

		  private function controllerDispatcher ()
		  {

				return (new ControllerDispatcher($this->dispatchController, $this->getParams ()))->getContent ();

		  }

		  private function response ($response = '')
		  {

				if ( $response instanceof ShouldBeResponseInterface ) {
					 $response->execute ();
				}

		  }

		  /**
			* @return bool
			*/
		  private function accessChecker ()
		  {

				$access = $this->access;
				if ( null === $access ) {
					 return true;
				}
				$next = $this->next;
				$request = new Request();
				$role = $this->role;
				$handle = call_user_func_array ([ $access, 'handle' ], [ $request, $next, $role ]);
				if ( $handle ) {
					 return true;
				} else {

					 if ( $access instanceof TerminateInterface ) {
						  call_user_func_array ([ $access, 'terminate' ], [ $request ]);
					 }

				}
		  }

		  /**
			*
			*
			* Before olayını test eder
			* @return bool
			*/
		  private function beforeChecker ()
		  {

				if ( null === $this->before ) {
					 return true;
				}


				if ( call_user_func_array ($this->before, $this->getParams ()) ) {

					 return true;
				}

		  }
	 }
