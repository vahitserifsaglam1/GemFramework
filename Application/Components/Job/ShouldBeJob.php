<?php

namespace Gem\Components\Job;
/**
 * interface JobDispatcherInterface
 * @package Gem\Components\Job
 * Bu interface Job Sınıflarında dispatch methodunu kullanmayı zorunlu kılar
 */
interface ShouldBeJob {
    public function dispatch();
}