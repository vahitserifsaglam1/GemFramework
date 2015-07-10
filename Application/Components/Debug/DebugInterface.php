<?php

namespace Gem\Components\Debug;

/**
 * Interface DebugInterface
 *
 * @package Gem\Components\Debug
 */

interface DebugInterface {

    public function addToList($list = []);
    public function clean();
    public function getAll();

}