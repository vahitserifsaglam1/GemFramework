<?php

    /**
     * Bu Sınıf GemFramework'de Event İşlemleri yapılması için tasarlanmıştır
     */

    namespace Gem\Components;

    use Exception;
    use Gem\Components\Event\EventCollector;
    use Gem\Components\Event\Event as EventDispatch;
    use Gem\Components\Event\EventListener;
    use InvalidArgumentException;

    /**
     *
     * Class Event
     * @package Gem\Components
     */

    class Event
    {


        /**
         * @var array
         */

        private $firing;


        /**
         * @var EventCollector
         */
        private $collector;


        public function __construct(EventCollector $collector = null)
        {

            $this->collector = $collector;
            $this->listeners = $this->collector->getListeners();
        }

        /**
         * Event'i yürütür
         * $eventName 'sınıfın ismi veya direk sınıfın instance i olabilir
         *
         * @param string $eventName
         * @return array
         * @throws Exception
         */
        public function fire($eventName = '')
        {

            if (is_string($eventName) || $eventName instanceof EventDispatch) {

                if ($eventName instanceof EventDispatch) {
                    $eventInstance = $eventName;
                    $eventName = get_class($eventName);
                } elseif (is_string($eventName)) {
                    $eventName = new $eventName();
                }
                if ($this->hasListiner($eventName)) {
                    $listeners = $this->getListeners($eventName);
                    $response = $this->runListenersHandle($listeners, $eventInstance);
                    if (count($response) === 1) {
                        $response = $response[0];
                    }
                    $this->firing[] = $response;

                    return $response;
                } else {

                    throw new Exception(sprintf('%s adındaki Event\' in herhangi bir dinleyicisi yok', $eventName));
                }
            } else {
                throw new InvalidArgumentException('Girdiğiniz Event, geçerli bir event değil');
            }
        }

        /**
         * Listener'ları yürütür
         *
         * @param array $listeners
         * @param null  $eventName
         * @throws Exception
         * @return array
         */
        private function runListenersHandle(array $listeners = [], $eventName = null)
        {

            $response = [];
            foreach ($listeners as $listener) {

                $listener = new $listener();
                if ($listener instanceof EventListener) {

                    $response[] = call_user_func_array([$listener, 'handle'], [$eventName]);
                } else {

                    throw new Exception(sprintf('%s listener sınıfı EventListenerInterface\' e sahip olmalıdır',
                       get_class($listener)));
                }
            }

            return $response;
        }

        public function getListeners($eventName = '')
        {

            if (!is_string($eventName)) {
                throw new InvalidArgumentException('event adı geçerli bir string değeri olmalıdır');
            }

            return $this->listeners[$eventName];
        }

        /**
         * Girilen event'in bir dinleyicisi varmı diye bakar
         *
         * @param string $eventName
         * @return bool
         */
        public function hasListiner($eventName = '')
        {

            return isset($this->listeners[$eventName]);
        }

        /**
         * En son çağrılan event'i döndürür
         *
         * @return mixed
         */
        public function firing()
        {

            return end($this->firing);
        }
    }
