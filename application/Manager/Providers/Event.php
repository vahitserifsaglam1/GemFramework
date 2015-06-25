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
 *  GemFramework Event Provider : Event Component' ini kullanıma hazırlar
 *
 */
use Gem\Components\Application;

class Event {
    public function __construct(Application $application){
        $application->singleton('Gem\Components\Event', [$application]);
        $application->runEvent();
    }
}