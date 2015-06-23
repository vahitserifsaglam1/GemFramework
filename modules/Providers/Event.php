<?php
/**
 *
 *  GemFramework Event Provider : Event Component' ini kullanıma hazırlar
 *
 */
namespace Gem\Modules\Providers;
use Gem\Components\Application;
class Event {

    public function __construct(Application $application){

        $application->singleton('Gem\Components\Event', [$application]);
        $application->runEvent();

    }
}
