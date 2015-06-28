<?php
/**
 * Created by PhpStorm.
 * User: vserifsaglam
 * Date: 24.6.2015
 * Time: 21:23
 */

namespace Gem\Manager\Providers;
/**
 *
 *  GemFramework Events Provider : Events Component' ini kullanıma hazırlar
 *
 */
use Gem\Components\Application;
class Event {

    protected $events = [

        'Gem\Events\TestEvent' => [
            'Gem\Listeners\TestEventListener'
        ]];

    /**
     * Events sınıfını oluşturur ve listener ları atar
     * @param Application $application
     */
    public function __construct(Application $application){
        $event = $application->singleton('Gem\Components\Event\EventCollector', [$application]);
        $event->setListeners($this->events);
        $application->singleton('Gem\Components\Event',[$event]);


    }
}
